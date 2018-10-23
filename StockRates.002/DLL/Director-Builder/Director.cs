using StockRates._002.DLL.Builder;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace StockRates._002.DLL.Director_Builder
{
    class Director
    {
        public void BuildProduction(IDatabaseBuilder builder)
        {
            builder.BuildConnection("MySqlConn");
            builder.BuildCommand();
            builder.SetSettings();
        }

        public void BuildBackup(IDatabaseBuilder builder)
        {
            builder.BuildConnection("BackupMySqlConn");
            builder.BuildCommand();
            builder.SetSettings();
        }


    }
}
