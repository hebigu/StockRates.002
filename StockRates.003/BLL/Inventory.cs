using System;
using System.Collections.Generic;
using System.Configuration;
using System.Threading;
using StockRates._003.DLL;
using StockRates._003.DLL.FileAbstractFactory;

namespace StockRates._003.BLL
{
    public class Inventory : IInventory
    {
        private WebLayer webLayer = new WebLayer();

        private IFileAccess iFileAccess = new FileAccess();

        private DataLayer dataLayer = new DataLayer();
           
        private Decimal GetInventoryStockPortfolioValue(int currentBatchNumber)
        {
            return dataLayer.GetInventoryStockPortfolioValue(currentBatchNumber);
        }

        private int UpdateLastFetchTime()
        {
            return dataLayer.UpdateLastFetchTime();
        }

        private int UpdateControlInUse(Boolean inUse)
        {
            return dataLayer.UpdateControlInUse(inUse : inUse);
        }

        private static bool RealisticValueCaptured(decimal beforeValue, decimal afterValue)
        {
            bool result = true;

            var maxDeviationProcent = ConfigurationManager.AppSettings["MaxDeviation"];

            if (afterValue < beforeValue * (100 + Convert.ToDecimal(maxDeviationProcent)) / 100)
                result = true;
            else
                result = false;

            if (result && afterValue > beforeValue * (100 - Convert.ToDecimal(maxDeviationProcent)) / 100)
                result = true;
            else
                result = false;

            return result;
        }

        private static Decimal GetInsertMarginValue()
        {
            var decimalSystemPoint = Convert.ToChar(System.Globalization.CultureInfo.CurrentCulture.NumberFormat.NumberDecimalSeparator);

            return GetSystemConvertedInsertMargin(decimalSystemPoint);
        }

        private static Decimal GetSystemConvertedInsertMargin(char decimalSystemPoint)
        {
            var insertMarginValue = ConfigurationManager.AppSettings["InsertMargin"];

            if (decimalSystemPoint == ',')
            {
                insertMarginValue = insertMarginValue.Replace('.', decimalSystemPoint);
            }
            else
            {
                insertMarginValue = insertMarginValue.Replace(',', decimalSystemPoint);
            }
            return Convert.ToDecimal(insertMarginValue);
        }

        public Inventory()
        {
            byte testNo = 0;

            List<Stock> stockRates;
            int countInUse;
            try
            {
                if (testNo == 0)
                {
                    int countRow = UpdateLastFetchTime();

                    var currentBatchNumber = dataLayer.GetCurrentBatchNo();

                    //Last value reported
                    decimal batchValueBeforeThisInsert = GetInventoryStockPortfolioValue(currentBatchNumber);

                    stockRates = webLayer.GetStockRates(testNo); //Yahoo stop exposing stockrates 31.10.2017 as csv

                    if (currentBatchNumber != -1) currentBatchNumber++;

                    var maxDeviationProcent = ConfigurationManager.AppSettings["MaxDeviation"];

                    countInUse = UpdateControlInUse(inUse: true);

                    if (currentBatchNumber > 0)
                    {
                        Thread.Sleep(1000);

                        Console.WriteLine("Writing to database");
                           
                        try
                        {
                            var count = dataLayer.InsertStocksIntoDatabase(stockRates, currentBatchNumber);
                        }
                        catch
                        {
                            Console.WriteLine("Something went wrong trying to write to database, deleting batch # {0}", currentBatchNumber);

                            dataLayer.DeleteFromTable(currentBatchNumber);

                            throw;
                        }
                    }
                    decimal batchValueAfterThisInsert = GetInventoryStockPortfolioValue(currentBatchNumber);

                    var numberOfDifferentStocks = dataLayer.GetAllMyStocksFromInventory().Count;
                    // Get amount of stock rates stored in database
                    var numberOfDifferentStocksStoredInLastBatchNoInDb = dataLayer.GetNumberOfDifferentStocksStoredInLastBatchNo();

                    bool bypassMaxDeviation = ConfigurationManager.AppSettings["BypassMaxDeviation"] == "true" ? true : false;

                    if (!RealisticValueCaptured(batchValueBeforeThisInsert, batchValueAfterThisInsert) && !bypassMaxDeviation)
                    {
                        Console.WriteLine("We have som unrealistic value when fetching data, we should have max deviation of " + maxDeviationProcent + ", former value says " + batchValueBeforeThisInsert + ", now we have " + batchValueAfterThisInsert);

                        Console.WriteLine("Therefore deleting batchnumber " + currentBatchNumber + " from db");

                        dataLayer.DeleteFromTable(currentBatchNumber);

                        throw new Exception("Batch " + currentBatchNumber + " is deleted " + ",consolidated stockvalue before insert is " + batchValueBeforeThisInsert + ", Consolidated stockvalue after insert is " + batchValueAfterThisInsert);
                    }
                }
                else
                {
                    stockRates = webLayer.GetStockRates(testNo);
                }
            }
            catch (Exception e)
            {
                iFileAccess.AppendLog(string.Format("Error exception {0}", e.Message + System.Environment.NewLine + e.GetBaseException()));
                Console.WriteLine(e.Message);
                throw;
            }
            finally
            {
                Thread.Sleep(Convert.ToInt32(ConfigurationManager.AppSettings["Delay"]));
                countInUse = UpdateControlInUse(inUse: false);
            }
        }
    }
}
