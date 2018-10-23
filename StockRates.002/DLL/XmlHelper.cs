using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace StockRates._002.DLL
{
    //public static class XmlHelper
    //{
        //public static string GetNameFromStockCode(string stockCode)
        //{
        //    XmlDocument doc = new XmlDocument();
        //    doc.Load(@"..\..\Resources\StocksInventory.xml");
        //    var nodes = doc.DocumentElement.SelectNodes("/Stocks/Stock");

        //    string name = null;

        //    foreach (XmlNode node in nodes)
        //    {
        //        if (node["StockCode"].InnerText == stockCode)
        //        {
        //            name = node["Name"].InnerText;
        //        }
        //    }
        //    return name;
        //}

        //public static int GetNumberOfDifferentStocksInXml()
        //{
        //    XmlDocument doc = new XmlDocument();
        //    doc.Load(@"..\..\Resources\StocksInventory.xml");
        //    var nodes = doc.DocumentElement.SelectNodes("/Stocks/Stock");

        //    int numberOfDifferentStocksInXml = 0;

        //    foreach (XmlNode node in nodes)
        //    {
        //        numberOfDifferentStocksInXml++;
        //    }
        //    return numberOfDifferentStocksInXml;
        //}
    //}
}
