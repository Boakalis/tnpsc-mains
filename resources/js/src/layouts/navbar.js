import { React, useContext, useState, useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import Stack from "@mui/material/Stack";
import { styled, alpha } from "@mui/material/styles";
import InputBase from "@mui/material/InputBase";
import SearchIcon from "@mui/icons-material/Search";
import "./Navbar.css";
import Button from "@mui/material/Button";
import AuthContext from "./../store/auth-context";
import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";
import Typography from "@mui/material/Typography";
import Menu from "@mui/material/Menu";
import MenuIcon from "@mui/icons-material/Menu";
import Container from "@mui/material/Container";
import Avatar from "@mui/material/Avatar";
import Tooltip from "@mui/material/Tooltip";
import MenuItem from "@mui/material/MenuItem";
import AdbIcon from "@mui/icons-material/Adb";
import MailIcon from "@mui/icons-material/Mail";
import NotificationsIcon from "@mui/icons-material/Notifications";
import Badge from "@mui/material/Badge";
import AccountCircle from "@mui/icons-material/AccountCircle";
import MailOutlineRoundedIcon from "@mui/icons-material/MailOutlineRounded";
import NotificationsOutlinedIcon from "@mui/icons-material/NotificationsOutlined";
import axios from "../helpers/axios";
import LinearProgress from "@mui/material/LinearProgress";
import Notification from "../components/Notification";

const NavBar = () => {
    const modalState = useSelector((state) => state.modalReducer.isOpen);
    const paymentLoader = useSelector(
        (state) => state.modalReducer.paymentLoader
    );
    const dispatch = useDispatch();

    const auth = useSelector((state) => state.authentication.user);

    const loginModal = () => {
        dispatch({ type: "OPEN_LOGIN_MODAL" });
    };

    const registerModal = () => {
        dispatch({ type: "OPEN_REGISTER_MODAL" });
    };

    const getProfile = () => {};
    const changePassword = () => {};
    const logOut = () => {
        axios.post("/log-out").then((resp) => {
            window.location.reload();
        });
    };

    // const settings = [
    //   {
    //     title: "Profile",
    //     function: {getProfile},
    //   },
    //   {
    //     title: "Change Password",
    //     function: {changePassword},
    //   },
    //   {
    //     title: "Logout",
    //     function: {logOut},
    //   },
    // ];

    const [anchorElNav, setAnchorElNav] = useState(null);
    const [anchorElUser, setAnchorElUser] = useState(null);

    const handleOpenNavMenu = (event) => {
        document.getElementById("layout").classList.add("layout-menu-expanded");
    };
    const handleOpenUserMenu = (event) => {
        setAnchorElUser(event.currentTarget);
    };

    const handleCloseNavMenu = () => {
        document
            .getElementById("layout")
            .classList.remove("layout-menu-expanded");
    };

    const handleCloseUserMenu = () => {
        setAnchorElUser(null);
    };

    return (
        <>
            <div id="price-root"></div>
            <AppBar position="static" style={{ backgroundColor: "white" }}>
                <Container maxWidth="xl">
                    <Toolbar disableGutters>
                        <Box sx={{ flexGrow: 1 }} />
                        <Box
                            spacing={2}
                            sx={{ display: { xs: "flex", md: "flex" } }}
                            style={{ display: "flex", alignItems: "center" }}
                        >
                            {!auth ? (
                                <>
                                    {" "}
                                    <Button
                                        color="primary"
                                        onClick={loginModal}
                                        variant="contained"
                                        className="mx-1 neu-btn"
                                    >
                                        Login
                                    </Button>{" "}
                                    <Button
                                        color="success"
                                        onClick={registerModal}
                                        variant="contained"
                                        className="mx-1 neu-btn"
                                    >
                                        Register
                                    </Button>
                                </>
                            ) : (
                                <>
                                    {" "}
                                    {/* <IconButton
                    size="small"
                    aria-label="show 4 new mails"
                    color="inherit"
                  >
                    <Badge badgeContent={4} variant="dot" color="error">
                      <MailOutlineRoundedIcon color="action" />
                    </Badge>
                  </IconButton>
                  <IconButton
                    size="small"
                    className="mx-3"
                    aria-label="show 17 new notifications"
                    color="inherit"
                  >
                    <Badge badgeContent={17} variant="dot" color="error">
                      <NotificationsOutlinedIcon color="action" />
                    </Badge>
                  </IconButton> */}
                                    <Notification></Notification>
                                    {/* <span
                    className="mx-3 text-center"
                    style={{ color: "black" ,display:"flex",alignItems:"center" }}
                    textAlign="center"
                  >
                    <p className="my-0 py-0 text-uppercase" style={{ fontSize: "16px" }}>
                      {" "}
                      {auth.name}
                    </p>

                  </span> */}
                                    <Tooltip title="Profile Settings">
                                        <IconButton
                                            className="mx-2"
                                            onClick={handleOpenUserMenu}
                                            sx={{ p: 0 }}
                                        >
                                            <i
                                                style={{ fontSize: "0.8em" }}
                                                className="fa-solid fa-user"
                                            ></i>
                                        </IconButton>
                                    </Tooltip>
                                    <Tooltip title="Profile Settings">
                                        <p
                                            onClick={handleOpenUserMenu}
                                            className="my-0 py-0  text-uppercase"
                                            style={{
                                                fontSize: "16px",
                                                color: "black",
                                            }}
                                        >
                                            {" "}
                                            {auth.name}
                                        </p>
                                    </Tooltip>
                                    <Menu
                                        sx={{ mt: "45px" }}
                                        id="menu-appbar"
                                        anchorEl={anchorElUser}
                                        anchorOrigin={{
                                            vertical: "top",
                                            horizontal: "right",
                                        }}
                                        keepMounted
                                        transformOrigin={{
                                            vertical: "top",
                                            horizontal: "right",
                                        }}
                                        open={Boolean(anchorElUser)}
                                        onClose={handleCloseUserMenu}
                                    >
                                        <MenuItem
                                            onClick={() => {
                                                dispatch({
                                                    type: "OPEN_CHANGE_PASSWORD_MODAL",
                                                });
                                                handleCloseUserMenu();
                                            }}
                                        >
                                            <Typography textAlign="center">
                                                Change Password
                                            </Typography>
                                        </MenuItem>
                                        <MenuItem
                                            onClick={() => {
                                                handleCloseUserMenu();
                                                logOut();
                                            }}
                                        >
                                            <Typography textAlign="center">
                                                Logout
                                            </Typography>
                                        </MenuItem>
                                    </Menu>{" "}
                                </>
                            )}
                        </Box>
                    </Toolbar>
                </Container>
            </AppBar>
            {paymentLoader ? <LinearProgress position="fixed" /> : ""}
        </>
    );
};

export default NavBar;
