using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using StockRates._002.BLL;

namespace UnitTestProject2
{
    [TestClass]
    public class UnitTest1
    {
        [TestMethod]
        public void TestMethodWithAllItemsIncluded()
        {
            try
            {
                IInventory IInventory = new Inventory();
                IInventory.Inventory(testNo: 1);            
            }
            catch(Exception ex) 
            {
                throw new AssertFailedException(
                    String.Format("An exception was not expected, but thrown, message is {0}", ex.Message)
                    );
                throw; 
            }
        }


        [TestMethod]
        public void TestMethodWithoutCurrentPrice()
        {
            try
            {
                IInventory IInventory = new Inventory();
                IInventory.Inventory(testNo: 2);            
            }
            catch(Exception ex) 
            {
                throw new AssertFailedException(
                    String.Format("An exception was not expected, but thrown, message is {0}", ex.Message)
                    );
                throw; 
            }
        }

        
        [TestMethod]
        public void TestMethodWithoutCurrentPriceAndAMinusForAlternative()
        {
            try
            {
                IInventory IInventory = new Inventory();
                IInventory.Inventory(testNo: 3);            
            }
            catch(Exception ex) when (ex.Message == "Cannot find regularMarketPriceElement for CARL-B.CO")
            {
            }
            catch (Exception ex)
            {
                throw new AssertFailedException(
                    String.Format("An exception was not expected, but thrown, message is {0}", ex.Message)
                    );
                throw; 
            }
        }



        [TestMethod]
        public void TestMethodWithoutAnyUsableTags()
        {
            try
            {
                IInventory IInventory = new Inventory();
                IInventory.Inventory(testNo: 4);            
            }
            catch(Exception ex) when (ex.Message == "Cannot find regularMarketPriceElement for CARL-B.CO")
            {
            }
            catch (Exception ex)
            {
                throw new AssertFailedException(
                    String.Format("An exception was not expected, but thrown, message is {0}", ex.Message)
                    );
                throw; 
            }
        }

    }
}
