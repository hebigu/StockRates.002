using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.Common;
using MySql.Data.MySqlClient;
using StockRates._003.DLL.DbAbstractFactory;

namespace StockRates._003.DLL
{
    public class DataLayer
    {
        private Database database = new MySqlDatabase();

        DbDataReader reader = null;

        public int GetCurrentBatchNo()
        {
            var command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetMaxCountStatement("BatchNo");   

            var currentBatchNumber = 0;

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                currentBatchNumber = reader.Read() ? reader.GetInt32(0) : -1;
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return currentBatchNumber;
        }

        public decimal GetInventoryStockPortfolioValue(int batchNo)
        {
            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetCurrentInventoryStockPortfolioValueStatement(batchNo);

            decimal inventoryStockPortfolioValue;

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                inventoryStockPortfolioValue = reader.Read() ? reader.GetDecimal(0) : -1;
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return inventoryStockPortfolioValue;
        }


        public int UpdateLastFetchTime(Boolean fromBackup = false)
        {
                        string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;
            }

              database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetUpdateLastFetchTime();

            int count = 0;

            try
            {
                command.Connection.Open();

                count = command.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;

        }

        public int UpdateControlInUse(Boolean fromBackup = false, Boolean inUse = false)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;
            }

            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetUpdateStatementForControl(inUse);

            int count = 0;

            try
            {
                command.Connection.Open();

                count = command.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;

        }


        public List<int> GetBatchNumbers(Boolean fromBackup = false, byte testNo = 0)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;
            }

            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetBatchNumbers();

            List<int> batchNumbers = new List<int>();

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                batchNumbers = DataLayerHelper.MapReaderToBatchNumbers(reader);
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return batchNumbers;

        }


        public List<Stock> GetStocksInBatch(int batchNo, Boolean fromBackup = false)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;
            }
            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetSelectStocksForBatchStatement(batchNo);

            List<Stock> stocks = new List<Stock>();

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                stocks = DataLayerHelper.MapReaderToStocks(reader);
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return stocks;
        }

        public List<Stock> GetAllMyStocksFromInventory(byte testNo = 0)
        {
            string connectionString = null;
            
            connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetSelectMyStockInventory();

            List<Stock> stocks = new List<Stock>();

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                stocks = DataLayerHelper.MapReaderToStocksInventory(reader);
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return stocks;
        }

        public bool GetCanBeIgnored(string stockCode)
        {
            string connectionString = null;

            connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetSelectCanBeIgnoredFlag(stockCode);

            bool canBeIgnored = false;

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                canBeIgnored = DataLayerHelper.MapReaderToCanBeIgnored(reader);
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if (reader != null) reader.Close();

                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return canBeIgnored;
        }




        public int InsertDataIntoDatabase(Stock stock, int batchNo, Boolean toBackup = false)
        {
            string connectionString = null;
            if (toBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            }
            database.Connection = new MySqlConnection(connectionString);


            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetInsertStatement(stock, batchNo, toBackup);

            int count;

            try
            {
                command.Connection.Open();

                count = command.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;
        }

        public int InsertStocksIntoDatabase(List<Stock> stocks, int batchNo, Boolean toBackup = false)
        {
            string connectionString = null;
            if (toBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            }
            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            int sumCount = 0;
            try
            {
                foreach (Stock stock in stocks)
                {
                    if (stock.Rate > 0 && !stock.CanBeIgnored)
                    {
                        command.CommandText = SqlBuilder.GetInsertStatement(stock, batchNo, toBackup);
                        int count;
                        command.Connection.Open();
                        count = command.ExecuteNonQuery();
                        sumCount += count;
                    }
                }
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return sumCount;
        }




        public int DeleteFromTable(int batchNo)
        {
            string connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.DeleteInventoryStocksByBatchNo(batchNo);

            int count;

            try
            {
                command.Connection.Open();

                count = command.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;
        }

        public int GetNumberOfDifferentStocksStoredInLastBatchNo(Boolean fromBackup = false)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            }
            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetNumberOfDifferentStocksStoredInLastBatchNo();

            int count;

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                count = reader.Read() ? reader.GetInt32(0) : -1;

            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;
        }


        public int GetNumberOfStockItemsWhichCaneBeIgnored(Boolean fromBackup = false)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            }
            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetSelectCountOfCanBeIgnored();

            int count;

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();

                count = reader.Read() ? reader.GetInt32(0) : -1;

            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }
            return count;
        }

        public List<Decimal> GetLastInsertedStocks(string stockCode, int take = 2, Boolean fromBackup = false)
        {
            string connectionString = null;
            if (fromBackup)
            {
                connectionString = ConfigurationManager.ConnectionStrings["BackupMySqlConn"].ConnectionString;
            }
            else
            {
                connectionString = ConfigurationManager.ConnectionStrings["MySqlConn"].ConnectionString;

            }
            database.Connection = new MySqlConnection(connectionString);

            DbCommand command = database.Command;

            command.CommandType = CommandType.Text;

            command.CommandText = SqlBuilder.GetLastInsertedStocks(stockCode, take);

            List<Decimal> rateCurrencyRates = new List<decimal>();

            try
            {
                command.Connection.Open();

                reader = command.ExecuteReader();
                               
                rateCurrencyRates = DataLayerHelper.MapReaderToRateCurrencyRate(reader);

            }
            catch (Exception e)
            {
                throw new Exception(e.Message);
            }
            finally
            {
                if ((command.Connection.State & ConnectionState.Open) != 0)
                {
                    command.Connection.Close();
                }
            }

            return rateCurrencyRates;
        }
    }
}
