using System.Collections.Generic;
using StockRates._002.DLL.WebAbstractFactory;

namespace StockRates._002.DLL
{
    public class WebLayer
    {
        private IWebAccess iWebAccess = new YahooAccess();

        public List<Stock> Stocks
        {
            get
            {
                return iWebAccess.Stocks;
            }
        }

        public List<Stock> GetStockRates(byte testNo = 0)
        {
            return iWebAccess.GetStockRates(testNo);
        }
    }
}
