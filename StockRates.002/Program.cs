using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using StockRates._002.BLL;

namespace StockRates._002
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine(DateTime.Now +  " StockRates version 2.13.00");
            if (args.Length == 1)
            {
                switch (args[0])
                {
                    case "InventoryMaintenance":
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

