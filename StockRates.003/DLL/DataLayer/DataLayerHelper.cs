using System;
using System.Collections.Generic;
using System.Data.Common;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._003.DLL
{
    public static class DataLayerHelper
    {
        public static List<Stock> MapReaderToStocks(DbDataReader dbDataReader)
        {
            var stocks = new List<Stock>();

            while (dbDataReader.Read())
            {
                stocks.Add(new Stock()
                    {
                        StockCode = dbDataReader.GetString(0),
                        Number = dbDataReader.GetInt32(1),
                        Rate = dbDataReader.GetDecimal(2),
                        Change = dbDataReader.GetDecimal(3),
                        Date = dbDataReader.GetDateTime(4).Date,
                        Time = dbDataReader.GetDateTime(4),
                        Currency = dbDataReader.GetString(5),
                        CurrencyRate = dbDataReader.GetDecimal(6),
                        Name = dbDataReader.GetString(8),
                        CurrentDateTime = dbDataReader.GetDateTime(7)
                    }
                    );
            }
            return stocks;
        }

        public static List<Stock> MapReaderToStocksInventory(DbDataReader dbDataReader)
        {
            var stocks = new List<Stock>();

            while (dbDataReader.Read())
            {
                stocks.Add(new Stock()
                {
                    Name = dbDataReader.GetString(0),
                    StockCode = dbDataReader.GetString(1),
                    Currency = dbDataReader.GetString(2),
                    Number = dbDataReader.GetInt32(3)
                }
                );
            }
            return stocks;
        }


        public static List<int> MapReaderToBatchNumbers(DbDataReader dbDataReader)
        {
            List<int> batchNumbers = new List<int>();

            while (dbDataReader.Read())
            {
                batchNumbers.Add(dbDataReader.GetInt32(0));
            }

            return batchNumbers;
        }



        public static List<Decimal> MapReaderToRateCurrencyRate(DbDataReader dbDataReader)
        {
            List<Decimal> rateCurrencyRates = new List<decimal>();

            while (dbDataReader.Read())
            {
                rateCurrencyRates.Add(dbDataReader.GetDecimal(0));
            }

            return rateCurrencyRates;
        }

        public static List<Stock> MapReaderToStocksStaging(DbDataReader dbDataReader)
        {
            var stocks = new List<Stock>();

            while (dbDataReader.Read())
            {
                stocks.Add(new Stock()
                {
                    StockCode = dbDataReader.GetString(0),
                    Rate = dbDataReader.GetDecimal(1),
                 }
                 );
            }
            return stocks;

            //StockCode = items[0].Replace("\"", ""),
            //        Rate = decimal.Parse(items[1], _ni),
            //        Date = DateTime.ParseExact(FormatDate(items[2].Replace("\"", "")), "MM/dd/yyyy", null),
            //        Time = DateTime.Parse(items[3].Replace("\"", "")),
            //        Change = decimal.Parse(items[4], _ni)
        }

        public static bool MapReaderToCanBeIgnored(DbDataReader dbDataReader)
        {
            dbDataReader.Read();

            bool canBeIgnored = dbDataReader.GetBoolean(0);

            return canBeIgnored;
        }

    }
}
