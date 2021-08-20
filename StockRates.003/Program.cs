using Castle.MicroKernel.Registration;
using Castle.Windsor;
using StockRates._003.BLL;
using System;
using System.Globalization;

namespace StockRates._003
{
    class Program
    {
        static void Main(string[] args)
        {
            var container = new WindsorContainer();

            Console.WriteLine(DateTime.Now + " StockRates version 2.29.07");
            if (args.Length >= 1)
            {
                switch (args[0])
                {
                    case "InventoryMaintenance":
                        if (args.Length > 1)
                        {
                            CultureInfo ci = System.Threading.Thread.CurrentThread.CurrentCulture;
                            string decimalSeparator = ci.NumberFormat.CurrencyDecimalSeparator;

                            string configMarginValue = args[1];

                            if (decimalSeparator.Equals(","))
                                configMarginValue = configMarginValue.Replace(".", decimalSeparator);
                            else
                                configMarginValue = configMarginValue.Replace(",", decimalSeparator);

                            Decimal marginValue = Decimal.Parse(configMarginValue);

                            //Console.Write("Margin value is {0}|", marginValue);

                            if (marginValue < 3)
                                new InventoryMaintenance(marginValue);
                        }
                        else
                            new InventoryMaintenance();
                        break;
                    case "Replicate":
                        new Replicator();
                        break;
                }
                return;
            }

            container.Register(Component.For<IInventory>().ImplementedBy<Inventory>());

            container.Resolve<IInventory>();

            //IInventory IInventory = new Inventory();
            //IInventory.Inventory(testNo: 0);
        }
    }
}

