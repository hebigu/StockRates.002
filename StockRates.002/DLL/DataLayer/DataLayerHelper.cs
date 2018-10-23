using System;
using System.Collections.Generic;
using System.Data.Common;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._002.DLL
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
