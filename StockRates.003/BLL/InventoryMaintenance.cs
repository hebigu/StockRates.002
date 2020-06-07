using StockRates._003.DLL;
using System;
using System.Collections.Generic;
using System.Linq;

namespace StockRates._003.BLL
{
    class InventoryMaintenance
    {
        public InventoryMaintenance(Decimal marginValue = 0)
        {
            var dataLayer = new DataLayer();

            try
            {
                var firstBatchNumber = 1;

                var lastStocks = dataLayer.GetStocksInBatch(firstBatchNumber);

                var currentBatchNumber = dataLayer.GetCurrentBatchNo();

                List<int> batchNumbers = new List<int>();

                batchNumbers = dataLayer.GetBatchNumbers();
                                
                foreach(int batchNumber in batchNumbers)
                {
                    var newStocks = dataLayer.GetStocksInBatch(batchNumber);

                    if (newStocks.Any())
                    {
                        if (!InventoryHelper.InventoryPortFolioDifferentFromCurrentPortFolioValue(lastStocks, newStocks, marginValue) && batchNumber != batchNumbers.Min() &&  batchNumber != batchNumbers.Max())
                        {
                            Console.Write("-");
                            dataLayer.DeleteFromTable(batchNumber);
                        }
                        else
                        {
                            Console.Write("+");
                            lastStocks = newStocks;
                        }
                    }
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.Message);
            }
        }
    }
}
