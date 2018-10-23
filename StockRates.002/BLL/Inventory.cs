using System;
using System.Collections.Generic;
using System.Configuration;
using StockRates._002.DLL;
using StockRates._002.DLL.FileAbstractFactory;
using System.Xml;

namespace StockRates._002.BLL
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

        void IInventory.Inventory(byte testNo = 0)
        {
            List<Stock> stockRates;

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


                    if (currentBatchNumber > 0)
                    {
                        Console.WriteLine("Writing to database");

                        foreach (Stock stockRate in stockRates)
                        {
                            if (stockRate.Rate > 0 && !stockRate.CanBeIgnored)
                            {
                                try
                                {
                                    Console.WriteLine("Writing " + stockRate.Name + " currency " + stockRate.CurrencyRate);
                                    var count = dataLayer.InsertDataIntoDatabase(stockRate, currentBatchNumber);

                                    if (count == 0)
                                    {
                                        break;
                                    }
                                }
                                catch
                                {
                                    Console.WriteLine("Something went wrong trying to write to database stockname {0}", stockRate.Name);

                                    Console.WriteLine("Deleting batch # {0}", currentBatchNumber);

                                    dataLayer.DeleteFromTable(currentBatchNumber);

                                    throw;
                                }
                            }
                            else if (stockRate.Rate == 0 && !stockRate.CanBeIgnored)
                            {
                                throw new Exception("Stockrate is 0 for stockname " + stockRate.StockCode);
                            }
                        }
                    }

                    decimal batchValueAfterThisInsert = GetInventoryStockPortfolioValue(currentBatchNumber);

                    var numberOfDifferentStocks = dataLayer.GetAllMyStocksFromInventory().Count;
                    // Get amount of stock rates stored in database
                    var numberOfDifferentStocksStoredInLastBatchNoInDb = dataLayer.GetNumberOfDifferentStocksStoredInLastBatchNo();


                    if (!RealisticValueCaptured(batchValueBeforeThisInsert, batchValueAfterThisInsert))
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
        }
    }
}
