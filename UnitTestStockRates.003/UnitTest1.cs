using Microsoft.VisualStudio.TestTools.UnitTesting;
using StockRates._003.BLL;
using System.Configuration;

namespace UnitTestStockRates._003
{
    [TestClass]
    public class UnitTest1
    {
        [TestMethod]
        public void TestStockRates_003_01()
        {
            IInventory IInventory = new Inventory();
            IInventory.Inventory(testNo: 1);

        }
    }
}
