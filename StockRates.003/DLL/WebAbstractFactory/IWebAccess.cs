using System.Collections.Generic;

namespace StockRates._003.DLL.WebAbstractFactory
{
    public interface IWebAccess
    {
        List<Stock> Stocks { get; }
        //List<Stock> GetStockRatesOld();

        List<Stock> GetStockRates(byte testNo = 0);
    }
}
