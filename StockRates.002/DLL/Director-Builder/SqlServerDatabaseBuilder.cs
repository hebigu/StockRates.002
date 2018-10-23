using StockRates._002.DLL.DbAbstractFactory;
using System.Configuration;
using MySql.Data.MySqlClient;

namespace StockRates._002.DLL.Builder
{
    class MySqlDatabaseBuilder : IDatabaseBuilder
    {
        private Database _Database;

        public Database Database
        {
            get { return _Database; }
        }

        public void BuildConnection(string connectionName)
        {
            string connectionString = ConfigurationManager.ConnectionStrings[connectionName].ConnectionString;
            _Database.Connection = new MySqlConnection(connectionString);
        }
        
        public void BuildCommand()
        {
            _Database.Command = new MySqlCommand();
            _Database.Command.Connection = _Database.Connection;
        }

        public void SetSettings()
        {
            _Database.Command.CommandTimeout = 360;
            _Database.Command.CommandType = System.Data.CommandType.Text;
        }        
    }
}
