using System;
using System.Collections.Generic;
using StockRates._002.DLL.WebAbstractFactory;
using System.Net;
using System.Threading;
using System.Security.Cryptography.X509Certificates;
using System.Net.Security;

namespace StockRates._002.DLL
{
    public class YahooAccess : IWebAccess
    {
        private static List<Stock> _stocks = new List<Stock>();

        public List<Stock> Stocks
        {
            get
            {
                return _stocks;
            }
        }

        private static System.Globalization.NumberFormatInfo _ni = null;

        public YahooAccess()
        {
            System.Globalization.CultureInfo ci =
               System.Globalization.CultureInfo.InstalledUICulture;
            _ni = (System.Globalization.NumberFormatInfo)
               ci.NumberFormat.Clone();
            _ni.NumberDecimalSeparator = ".";
        }

        // Get a web response.
        private string GetWebResponse(string url)
        {
            // Make a WebClient.
            System.Net.WebClient web_client = new System.Net.WebClient();

            // Get the indicated URL.
            System.IO.Stream response = web_client.OpenRead(url);

            // Read the result.
            using (System.IO.StreamReader stream_reader = new System.IO.StreamReader(response))
            {
                // Get the results.
                string result = stream_reader.ReadToEnd();

                // Close the stream reader and its underlying stream.
                stream_reader.Close();

                // Return the result.
                return result;
            }
        }



        #region GetIndividual stockrate


        public static bool MyRemoteCertificateValidationCallback(System.Object sender,
    X509Certificate certificate, X509Chain chain, SslPolicyErrors sslPolicyErrors)
        {
            bool isOk = true;
            // If there are errors in the certificate chain,
            // look at each error to determine the cause.
            if (sslPolicyErrors != SslPolicyErrors.None)
            {
                for (int i = 0; i < chain.ChainStatus.Length; i++)
                {
                    if (chain.ChainStatus[i].Status == X509ChainStatusFlags.RevocationStatusUnknown)
                    {
                        continue;
                    }
                    chain.ChainPolicy.RevocationFlag = X509RevocationFlag.EntireChain;
                    chain.ChainPolicy.RevocationMode = X509RevocationMode.Online;
                    chain.ChainPolicy.UrlRetrievalTimeout = new TimeSpan(0, 1, 0);
                    chain.ChainPolicy.VerificationFlags = X509VerificationFlags.AllFlags;
                    bool chainIsValid = chain.Build((X509Certificate2)certificate);
                    if (!chainIsValid)
                    {
                        isOk = false;
                        break;
                    }
                }
            }
            return isOk;
        }

        private static string GetWebPageStringContent(string url)
        {
            String responseData = null;

            WebClient web = new WebClient();

            ServicePointManager.ServerCertificateValidationCallback = MyRemoteCertificateValidationCallback;

            System.IO.Stream stream = web.OpenRead(url);
            using (System.IO.StreamReader reader = new System.IO.StreamReader(stream))
            {
                responseData = reader.ReadToEnd();
            }

            return responseData;
        }

        private static string[] GetLines(string responseData)
        {
            string[] lines = responseData.Split(new[] { "\r\n", "\r", "\n" }, StringSplitOptions.None);

            return lines;
        }

        private static List<string> GetRelevantDatalines(string[] lines)
        {
            List<string> relevantDatalines = new List<string>();

            int position = 0;

            string patternToSearch = "<span class=\"Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)\" data-reactid=\"35\">";

            foreach (string line in lines)
            {
                if (line.StartsWith("root.App.now") || line.StartsWith("root.App.main"))
                {
                    relevantDatalines.Add(line);
                }

                position = line.IndexOf(patternToSearch);

                if (position > 0)
                {
                    relevantDatalines.Add(line);
                }

            }

            return relevantDatalines;
        }

        private static string[] GetrootAppmainElements(string rootAppmainPart)
        {
            string[] rootAppmainElements = rootAppmainElements = rootAppmainPart.Split(new[] { "," }, StringSplitOptions.None);

            return rootAppmainElements;
        }

        private static string GetCurrentPriceElement(string[] rootAppmainElements)
        {
            string currentPriceElement = null;

            foreach (string rootAppmainElement in rootAppmainElements)
            {
                if (rootAppmainElement.StartsWith("\"currentPrice\":"))
                {
                    currentPriceElement = rootAppmainElement;
                }
            }

            return currentPriceElement;
        }

        private static string GetAlternativCurrentPrice(string regularMarketPriceElement)
        {
            string result = null;

            string patternToSearch = "<span class=\"Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)\" data-reactid=\"35\">";
            int position = 0;
            int endposition = 0;

            position = regularMarketPriceElement.IndexOf(patternToSearch);


            if (position > 0)
            {
                patternToSearch = "</span>";
                endposition = regularMarketPriceElement.IndexOf(patternToSearch,position + 74);

                result = regularMarketPriceElement.Substring(position + 74, endposition-(position + 74));
            }

            return result;
        }


        private static string GetCurrentPrice(string regularMarketPriceElement)
        {
            string currentPrice = null;

            foreach (string element in regularMarketPriceElement.Split(new[] { ":" }, StringSplitOptions.None))
            {
                currentPrice = element;

            }

            return currentPrice;
        }

        private static string GetIndiviualStockRate(string stockName, byte testNo = 0)
        {
            string contents = null;

            if (testNo == 0)
            {
                string baseUrl = @"https://finance.yahoo.com/quote/@?p=@";

                string url = baseUrl.Replace("@", stockName);

                contents = GetWebPageStringContent(url);
            }
            else
            {
                contents = TestYahooAccess.GetWebPageStringContent(stockName, testNo);
            }


            string[] lines = GetLines(contents);

            List<string> relevantDatalines = GetRelevantDatalines(lines);

            string[] rootAppmainElements = null;

            if (relevantDatalines.Count > 2)
            {
                rootAppmainElements = GetrootAppmainElements(relevantDatalines[2]);
            }
            else
            {
                rootAppmainElements = GetrootAppmainElements(relevantDatalines[1]);
            }

            string regularMarketPriceElement = GetCurrentPriceElement(rootAppmainElements);

            //string regularMarketPriceElement = "currentPrice":{ "raw":774

            string regularMarketPrice = null;

            if (regularMarketPriceElement != null)
            {
                regularMarketPrice = GetCurrentPrice(regularMarketPriceElement);
            }
            else if (relevantDatalines.Count > 2)//Ups vi kunne ikke fiske kursen, vi prøver en anden metode
            {
                regularMarketPrice = GetAlternativCurrentPrice(relevantDatalines[0]);
            }

            DataLayer dataLayer = new DataLayer();

            if (regularMarketPrice == null || regularMarketPrice == "-") //Vi kan ikke finde kursen
            {
                if (!dataLayer.GetCanBeIgnored(stockName)) 
                {
                    throw new Exception("Cannot find regularMarketPriceElement for " + stockName);
                }

                if (regularMarketPrice == "-")
                {
                    regularMarketPrice = "0";
                }
            }
            return regularMarketPrice;
        }
        #endregion GetIndividual stockrate

        List<Stock> IWebAccess.GetStockRates(byte testNo = 0)
        {
            //const string base_url = @"https://finance.yahoo.com/quote/@?p=@";

            List<Stock> allMyStocks = new List<Stock>();

            Console.WriteLine("Now trying to fetch all configured stocks from database tables StockDetails and StockRatesInventoryTransactionDetails!");

            DataLayer dataLayer = new DataLayer();

            allMyStocks = dataLayer.GetAllMyStocksFromInventory();

            try
            {
                foreach (Stock stock in allMyStocks)
                {
                    Thread.Sleep(600);
                    Console.WriteLine("Now trying to fetch " + stock.StockCode + " from yahoo finance!");

                    string stockRateAsString = GetIndiviualStockRate(stock.StockCode, testNo);
                    if (stockRateAsString != null)
                    {
                        stock.Rate = decimal.Parse(stockRateAsString, _ni);
                    }
                }
            }
            catch
            {
                throw;
            }

            return allMyStocks;
        }

        private static string FormatDate(string date)
        {
            string[] dateComponents = date.Split('/');

            if (dateComponents[0].Length < 2)
            {
                dateComponents[0] = "0" + dateComponents[0];
            }

            if (dateComponents[1].Length < 2)
            {
                dateComponents[1] = "0" + dateComponents[1];
            }
            return dateComponents[0] + "/" + dateComponents[1] + "/" + dateComponents[2];
        }
    }
}
