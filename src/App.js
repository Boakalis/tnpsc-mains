import logo from "./logo.svg";
import "./App.css";
import { Routes, Route } from "react-router-dom";
import Master from "./layouts/master";
import Home from "./Home";
import PackageComponent from "./plans/plans";
import Content from "./content/Content";
import Login from "./pages/Login";
import AuthSecurity from "./helpers/AuthSecurity";





function App() {
  return (
    <Routes>
      <Route element={<Master />}>
        <Route index path="/exams" element={<Home />} />
        <Route path="/exams/:slug" exact element={<PackageComponent />} />
        <Route path="/exams/:slug/:plan" exact element={<Content />} />
      </Route>
    </Routes>
  );
}

export default App;
