using System;
using System.Configuration;
using System.IO;

namespace StockRates._002.DLL.FileAbstractFactory
{
    class FileAccess : IFileAccess
    {
        void IFileAccess.AppendLog(string text)
        {
            string file = ConfigurationManager.AppSettings["LogFile"];

            using (StreamWriter streamWriter = File.AppendText(file))
            {
                Log(text, streamWriter);
            }
        }

        private static void Log(string logMessage, TextWriter w)
        {
            w.Write("\r\nLog Entry : ");
            w.WriteLine("{0} {1}", DateTime.Now.ToLongTimeString(),
                DateTime.Now.ToLongDateString());
            w.Write("    :{0}", logMessage);
            w.WriteLine("-------------------------------");
        }
    }
}
