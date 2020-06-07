using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._003.BLL
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

        public static Boolean InventoryPortFolioDifferentFromCurrentPortFolioValue(List<Stock> stocksBase, List<Stock> stocksComp, Decimal marginValue = 0)
        {
            var inventoryPortFolioDifferentFromCurrentPortFolioValue = false;

            var lastStocksValue = GetCalculatedBatchStocksValue(stocksBase);

            var newStocksValue = GetCalculatedBatchStocksValue(stocksComp);

            if (marginValue == 0)
            {
                marginValue = GetInsertMarginValue();
            }

            var insertMarginValue = lastStocksValue * marginValue / 100;

            //Console.Write("|Insert Margin is {0}|", insertMarginValue);

            if (newStocksValue - insertMarginValue > lastStocksValue || newStocksValue + insertMarginValue < lastStocksValue)
            {
                inventoryPortFolioDifferentFromCurrentPortFolioValue = true;
            }
            return inventoryPortFolioDifferentFromCurrentPortFolioValue;
        }
    }
}
