using System;
using System.Runtime.CompilerServices;
using StockRates._003.DLL;

namespace StockRates._003
{
    public class Stock
    {
        private Decimal? _currencyRate;
        private string _stockCode;
        private DataLayer dataLayer = null;
        public string Name { get; set; }
 
        public string Currency { get; set; }
        public Decimal Rate { get; set; }
        public Decimal Change { get; set; }
        public DateTime Date { get; set; } 
        public DateTime Time { get; set; }
        public int Number { get; set; }
        public DateTime CurrentDateTime { get; set; }
        public bool CanBeIgnored { get; set; }



        public Stock()
        {
            dataLayer = new DataLayer();

            var ci =
               System.Globalization.CultureInfo.InstalledUICulture;
            var ni = (System.Globalization.NumberFormatInfo)
                ci.NumberFormat.Clone();
            ni.NumberDecimalSeparator = ".";
            Change = 0;
            Date = DateTime.Now.Date;
            Time = new DateTime(DateTime.Now.Ticks - DateTime.Now.Date.Ticks);
  
        }

        public Decimal CurrencyRate
        {
            get
            {
                Decimal currencyRate;

                if (_currencyRate == null)
                {
                    currencyRate = CurrencyHelper.GetCurrency(this.Currency);
                }
                else
                {
                    currencyRate = (Decimal)_currencyRate;
                }
                return currencyRate;
            }
            set { _currencyRate = value; }
        }

        public string StockCode
        {
            get
            {
                return _stockCode;
            }
            set
            {
                _stockCode = value;
                CanBeIgnored = dataLayer.GetCanBeIgnored(_stockCode);
            }
        }



    }
}
