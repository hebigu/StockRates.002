using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._002.BLL
{
    public static class InventoryHelper
    {
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

        private static decimal GetCalculatedBatchStocksValue(List<Stock> stocks)
        {
            decimal batchStocksValue = 0;

            foreach (Stock stock in stocks)
            {
                batchStocksValue += stock.Rate * stock.Number * stock.CurrencyRate;
            }
            return batchStocksValue;
        }

        public static Boolean InventoryPortFolioDifferentFromCurrentPortFolioValue(List<Stock> stocksBase, List<Stock> stocksComp)
        {
            var inventoryPortFolioDifferentFromCurrentPortFolioValue = false;

            var baseStocksValue = GetCalculatedBatchStocksValue(stocksBase);

            var compStocksValue = GetCalculatedBatchStocksValue(stocksComp);

            var insertMarginValue = baseStocksValue * GetInsertMarginValue() / 100;

            //Console.WriteLine("Insert Margin is {0}", insertMarginValue);

            if (compStocksValue - insertMarginValue > baseStocksValue || compStocksValue + insertMarginValue < baseStocksValue)
            {
                inventoryPortFolioDifferentFromCurrentPortFolioValue = true;
            }
            return inventoryPortFolioDifferentFromCurrentPortFolioValue;
        }
    }
}
