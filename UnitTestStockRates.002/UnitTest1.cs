using Microsoft.VisualStudio.TestTools.UnitTesting;
using StockRates._002.BLL;
using System.Configuration;

namespace UnitTestStockRates._002
{
    [TestClass]
    public class UnitTest1
    {
        [TestMethod]
        public void TestStockRates_002_01()
        {
            IInventory IInventory = new Inventory();
            IInventory.Inventory(testNo: 1);

        }
    }
}
