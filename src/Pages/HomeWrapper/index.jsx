import { Outlet } from "react-router-dom"
import Navbar from "../../Components/Navbar"
import Footer from "../../Components/Footer"

const HomeWrapper = () => {
  return (
    <div>
        <div className="bg-white text-center py-2">
            <p className="text-xs font-medium">Discover: New Fashions with BARA</p>
        </div>
        <Navbar />
        <div className="pb-28">
          {<Outlet />}
        </div>
        <Footer />
    </div>
  )
}

export default HomeWrapper