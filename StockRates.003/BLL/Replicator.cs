using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using StockRates._003.DLL;

namespace StockRates._003.BLL
{
    public class Replicator
    {
        public Replicator()
        {
            var dataLayer = new DataLayer();

            try
            {
                var currentBatchNumber = dataLayer.GetCurrentBatchNo();

                for (int batchNo = 1; batchNo <= currentBatchNumber; batchNo++)
                {
                    var stocksFromProduction = dataLayer.GetStocksInBatch(batchNo);

                    if (stocksFromProduction.Any())
                    {
                        var frombackup = true;
                        var stocksFromBackup = dataLayer.GetStocksInBatch(batchNo, frombackup);
                        if (!stocksFromBackup.Any())
                        {
                            foreach (var stockFromProduction in stocksFromProduction)
                            {
                                var toBackup = true;
                                dataLayer.InsertDataIntoDatabase(stockFromProduction, batchNo, toBackup);
                            }
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
