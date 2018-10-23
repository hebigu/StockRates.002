using System;
using System.Globalization;

namespace StockRates._002.DLL
{
    public static class SqlBuilder
    {
        public static string GetInsertStatement(Stock stock, int batchNo, Boolean toBackup)
        {
            string currentDateTime = toBackup?stock.CurrentDateTime.ToString("yyyy-MM-dd H:mm:ss", CultureInfo.InvariantCulture):DateTime.Now.ToString("yyyy-MM-dd H:mm:ss", CultureInfo.InvariantCulture);

            string sql = "INSERT INTO StockRates.StockRatesInventory " +
                        "(StockCode, BatchNo, Number, Rate, ChangeInRate, StockDate, Currency, CurrencyRate, CurrentDateTime) " +
                        "VALUES " +
                        "(" +
                        "'" + stock.StockCode + "'" +
                        "," + batchNo +
                        "," + stock.Number +
                        "," + stock.Rate.ToString().Replace(",", ".") +
                        "," + stock.Change.ToString().Replace(",", ".") +
                        ",'" + stock.Date.ToString("yyyy-MM-dd", CultureInfo.InvariantCulture) + " " + stock.Time.ToString("H:mm:ss", CultureInfo.InvariantCulture) + "'" +
                        ",'" + stock.Currency + "'" +
                         "," + stock.CurrencyRate.ToString().Replace(",", ".") +
                        ",'" +  currentDateTime + "'" +
                        ")";

            return sql;
        }

        public static string GetUpdateLastFetchTime()
        {
            string sql = "UPDATE StockRates.LastFetch SET lastFetchTime =  NOW()";

            return sql;
        }

        public static string GetInsertStatementWithCurrentTimeIncludede(Stock stock, int batchNo)
        {
            string sql = "INSERT INTO StockRates.StockRatesInventory " +
                        "(StockCode, BatchNo, Number, Rate, ChangeInRate, StockDate, Currency, CurrencyRate, CurrentDateTime) " +
                        "VALUES " +
                        "(" +
                        "'" + stock.StockCode + "'" +
                        "," + batchNo +
                        "," + stock.Number +
                        "," + stock.Rate.ToString().Replace(",", ".") +
                        "," + stock.Change.ToString().Replace(",", ".") +
                        ",'" + stock.Date.ToString("yyyy-MM-dd", CultureInfo.InvariantCulture) + " " + stock.Time.ToString("H:mm:ss", CultureInfo.InvariantCulture) + "'" +
                        ",'" + stock.Currency + "'" +
                         "," + stock.CurrencyRate.ToString().Replace(",", ".") +
                        ",'"  + "'" +
                        ")";

            return sql; 
        }

        public static string GetSelectMyStockInventory()
        {
            string sql = @"SELECT Name, StockDetails.StockCode, CurrencyOfStock AS Currency, SUM(StockRatesInventoryTransactionDetails.Number) AS Number FROM `StockRates`.`StockDetails` StockDetails
                            INNER JOIN `StockRates`.`StockRatesInventoryTransactionDetails` StockRatesInventoryTransactionDetails
                            ON StockDetails.StockCode = StockRatesInventoryTransactionDetails.StockCode
                            GROUP BY Name, StockCode, Currency";

            return sql;
        }

        public static string GetSelectStocksForBatchStatement(int batchNo)
        {
            string sql =
                "SELECT StockRatesInventory.StockCode, Number, Rate, ChangeInRate, StockDate, Currency, CurrencyRate, CurrentDateTime, StockDetails.Name FROM StockRates.StockRatesInventory AS StockRatesInventory " +
                " INNER JOIN StockRates.StockDetails AS StockDetails ON StockRatesInventory.StockCode = StockDetails.StockCode " +
                " WHERE BatchNo = " + batchNo +
                " ORDER BY Number";

            return sql;
        }

        public static string GetSelectCanBeIgnoredFlag(string stockName)
        {
            string sql =
                "SELECT CanBeIgnored FROM StockDetails WHERE StockCode = '" + stockName + "'";

            return sql;
        }

        public static string GetSelectCountOfCanBeIgnored()
        {
            string sql = "SELECT COUNT(*) FROM StockDetails WHERE CanBeIgnored <> 0";

            return sql;
        }

        public static string GetMaxCountStatement(string columnName)
        {
            return "SELECT MAX(" + columnName + ") FROM StockRates.StockRatesInventory;";
        }

        public static string GetCurrentInventoryStockPortfolioValueStatement(Decimal batchNo)
        {
            return "SELECT SUM(Number * Rate * CurrencyRate) FROM StockRates.StockRatesInventory WHERE BatchNo = " + batchNo;
        }

        public static string DeleteInventoryStocksByBatchNo(int batchNo)
        {
            return "DELETE FROM StockRates.StockRatesInventory WHERE BatchNo = " + batchNo;
        }

        public static string GetNumberOfDifferentStocksStoredInLastBatchNo()
        {
            return
                "SELECT Count(*) FROM StockRates.StockRatesInventory WHERE BatchNo = (SELECT MAX(BatchNo) FROM StockRates.StockRatesInventory)";
        }
    }
}
