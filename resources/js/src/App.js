import logo from "./logo.svg";
import "./App.css";
import { Routes, Route } from "react-router-dom";
import Master from "./layouts/master";
import Home from "./Home";
import PackageComponent from "./plans/plans";
import Content from "./content/Content";
import Login from "./pages/Login";
import AuthSecurity from "./helpers/AuthSecurity";
import AuthMiddleware from "./helpers/AuthMiddleware";
import Profile from "./pages/Profile";
import Course from "./pages/Course";
import Reports from "./pages/Reports";
import Dashboard from "./pages/Dashboard";
import Quotes from "./pages/Quotes";
import { GoogleOAuthProvider } from "@react-oauth/google";

function App() {
    return (
        <GoogleOAuthProvider clientId="671599041178-peonhuvr7ro3cb8nugq84gbu4mbj05su.apps.googleusercontent.com">
            <Routes>
                <Route element={<Master />}>
                    <Route
                        path="/profile"
                        element={
                            <AuthMiddleware>
                                <Profile />
                            </AuthMiddleware>
                        }
                    />
                    <Route
                        path="/my-courses"
                        element={
                            <AuthMiddleware>
                                <Course />
                            </AuthMiddleware>
                        }
                    />
                    <Route
                        path="/my-dashboard"
                        element={
                            <AuthMiddleware>
                                <Dashboard />
                            </AuthMiddleware>
                        }
                    />
                    <Route
                        path="/my-reports"
                        element={
                            <AuthMiddleware>
                                <Reports />
                            </AuthMiddleware>
                        }
                    />
                    <Route
                        path="/api-to-get-motivation-to-run-db-save"
                        element={
                            <AuthMiddleware>
                                <Quotes />
                            </AuthMiddleware>
                        }
                    />
                    <Route index path="/exams" element={<Home />} />
                    <Route
                        path="/exams/:slug"
                        exact
                        element={<PackageComponent />}
                    />
                    <Route
                        path="/exams/:slug/:plan"
                        exact
                        element={<Content />}
                    />
                </Route>
            </Routes>
        </GoogleOAuthProvider>
    );
}

export default App;


