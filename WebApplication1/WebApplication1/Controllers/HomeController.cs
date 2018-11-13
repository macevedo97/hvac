using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace WebApplication1.Controllers
{
    public class HomeController : Controller
    {
        public ActionResult Index()
        {
            return View();
        }

        public ActionResult About()
        {
            ViewBag.Message = "Your application description page.";

            return View();
        }

        public ActionResult Contact()
        {
            ViewBag.Message = "Customer Support";

            return View();
        }
        public ActionResult FAQ()
        {
            ViewBag.Message = "Frequently Asked Questions";

            return View();
        }

        public ActionResult AboutUs()
        {
            ViewBag.Message = "This is where you find out about us";

            return View();
        }

        public ActionResult Services()
        {
            ViewBag.Message = "We provide a range of services";

            return View();
        }

        public ActionResult HVAC101()
        {
            ViewBag.Message = "We provide a range of services";

            return View();
        }

        public ActionResult Home()
        {
            return View();
        }
    }
  
}  
