using StockRates._002.DLL.DbAbstractFactory;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._002.DLL.Builder
{
    interface IDatabaseBuilder
    {
        void BuildConnection(string conncetionName);
        void BuildCommand();
        void SetSettings();
        Database Database { get; }
    }
}
