using StockRates._002.DLL;
using System;
using System.Collections.Generic;
using System.Linq;

namespace StockRates._002.BLL
{
    class InventoryMaintenance
    {
        public InventoryMaintenance()
        {
            var dataLayer = new DataLayer();

            try
            {
                var firstBatchNumber = 1;

                var baseStocks = dataLayer.GetStocksInBatch(firstBatchNumber);

                var currentBatchNumber = dataLayer.GetCurrentBatchNo();

                for (int batchNo = 2; batchNo < currentBatchNumber; batchNo++)
                {
                    var compStocks = dataLayer.GetStocksInBatch(batchNo);

                    if (compStocks.Any() && !InventoryHelper.InventoryPortFolioDifferentFromCurrentPortFolioValue(baseStocks, compStocks))
                    {
                        Console.Write("-");
                        dataLayer.DeleteFromTable(batchNo);
                    }
                    else
                    {
                        Console.Write("+");
                        baseStocks = compStocks;
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
