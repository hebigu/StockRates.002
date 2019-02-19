using System;
using StockRates._002.BLL;

namespace StockRates._002
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine(DateTime.Now +  " StockRates version 2.15.00");
            if (args.Length >= 1)
            {
                switch (args[0])
                {
                    case "InventoryMaintenance":
                        if (args.Length > 1)
                            new InventoryMaintenance(Convert.ToDecimal(args[1]));
                        else
                            new InventoryMaintenance();
                        break;
                    case "Replicate":
                        new Replicator();
                        break;
                }
                return;
            }
            IInventory IInventory = new Inventory();
            IInventory.Inventory(testNo: 0);
        }
    }
}

