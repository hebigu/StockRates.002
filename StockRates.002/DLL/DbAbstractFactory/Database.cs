using System.Data.Common;

namespace StockRates._002.DLL.DbAbstractFactory
{
    public abstract class Database
    {
        public virtual DbConnection Connection { get; set; }
        public virtual DbCommand Command { get; set; }
    }
}
