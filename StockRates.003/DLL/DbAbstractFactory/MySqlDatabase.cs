using System.Configuration;
using System.Data.Common;
using MySql.Data.MySqlClient;

namespace StockRates._003.DLL.DbAbstractFactory
{
    public class MySqlDatabase : Database
    {
        private DbConnection _connection = null;
        private DbCommand _command = null;


        public override DbConnection Connection
        {
            get
            {
                if (_connection == null)
                {
                    string connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;
                    _connection = new MySqlConnection(connectionString);
                }
                return _connection;
            }
            set { _connection = value; }
        }

        public override DbCommand Command
        {
            get
            {
                _command = new MySqlCommand();
                _command.Connection = Connection;
                return _command;
            }
            set { _command = value; }
        }
    }
}
