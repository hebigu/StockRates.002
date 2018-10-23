using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;

namespace StockRates._002
{
    public static class CurrencyHelper
    {
        public static Decimal GetCurrency(string currencySign)
        {
            Decimal currencyValue = 1;

            var currencyRates = new List<KeyValuePair<string, decimal>>();

            DateTime currencyDate;

            currencyRates = GetCurrencyListFromWeb(out currencyDate);

            switch (currencySign)
            {
                case "EUR":
                    currencyValue = currencyRates.First(kvp => kvp.Key.Equals("DKK")).Value;
                    break;
            }
            return currencyValue;
        }

        private static List<KeyValuePair<string, decimal>> GetCurrencyListFromWeb(out DateTime currencyDate)
        {
            var returnList = new List<KeyValuePair<string, decimal>>();
            var date = string.Empty;
            using (System.Xml.XmlReader xmlr = System.Xml.XmlReader.Create(@"http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml"))
            {
                xmlr.ReadToFollowing("Cube");
                while (xmlr.Read())
                {
                    if (xmlr.NodeType != System.Xml.XmlNodeType.Element) continue;
                    if (xmlr.GetAttribute("time") != null)
                    {
                        date = xmlr.GetAttribute("time");
                    }
                    else returnList.Add(new KeyValuePair<string, decimal>(xmlr.GetAttribute("currency"), decimal.Parse(xmlr.GetAttribute("rate"), CultureInfo.InvariantCulture)));
                }
                currencyDate = DateTime.Parse(date);
            }
            returnList.Add(new KeyValuePair<string, decimal>("EUR", 1));
            return returnList;
        }
    }
}
