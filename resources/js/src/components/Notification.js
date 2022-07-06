import React, { useState, useEffect } from "react";
import Popover from "@mui/material/Popover";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import MailIcon from "@mui/icons-material/Mail";
import NotificationsIcon from "@mui/icons-material/Notifications";
import Badge from "@mui/material/Badge";
import AccountCircle from "@mui/icons-material/AccountCircle";
import MailOutlineRoundedIcon from "@mui/icons-material/MailOutlineRounded";
import NotificationsOutlinedIcon from "@mui/icons-material/NotificationsOutlined";
import IconButton from "@mui/material/IconButton";
import ClearIcon from "@mui/icons-material/ClearAll";
import axios from "../helpers/axios";
import ListItem from "@mui/material/ListItem";
import ListItemText from "@mui/material/ListItemText";
import List from "@mui/material/List";
import Divider from "@mui/material/Divider";
import Tooltip from "@mui/material/Tooltip";

export default function Notification() {
    const [anchorEl, setAnchorEl] = useState(null);
    const [datas, setDatas] = useState([]);
    const [change ,setChange] = useState(false);
    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const clearNotification = () => {
        axios
            .get("/clear-notifications")
            .then((resp) => {
                setChange(true);
            })
            .catch((error) => {});
    }

    useEffect(() => {
        axios
            .get("/notifications")
            .then((resp) => {
                setDatas(resp.data.data);
            })
            .catch((error) => {});
    }, [change]);

    const handleClose = () => {
        setAnchorEl(null);
    };

    const open = Boolean(anchorEl);
    const id = open ? "simple-popover" : undefined;

    return (
        <>
            <div>
                <Tooltip title="Notifications">
                    <IconButton
                        size="small"
                        className="mx-1"
                        aria-label="show 17 new notifications"
                        color="inherit"
                        aria-describedby={id}
                        variant="contained"
                        onClick={handleClick}
                    >
                        <Badge
                            badgeContent={datas.length}
                            variant="dot"
                            color="error"
                        >
                            <NotificationsOutlinedIcon color="action" />
                        </Badge>
                    </IconButton>
                </Tooltip>
                <Popover
                    style={{ borderRadius: "20px" }}
                    id={id}
                    open={open}
                    anchorEl={anchorEl}
                    onClose={handleClose}
                    anchorOrigin={{
                        vertical: "bottom",
                        horizontal: "left",
                    }}
                >
                    {datas.length > 0 ? (
                        <Typography>
                            <List dense={true}>
                                {datas.map((data) => (
                                    <>
                                        <ListItem>
                                            <ListItemText
                                                sx={{ p: 2 }}
                                                primary={`${data.title}`}
                                            />
                                        </ListItem>
                                        <Divider />
                                        <ListItem className="py-1">
                                            <ListItemText className="py-1" style={{cursor:"pointer"}}
                                                sx={{ p: 2 }}
                                                onClick={clearNotification}
                                                primary={`Clear All Notfications`}
                                            />
                                        </ListItem>
                                    </>
                                ))}
                            </List>
                        </Typography>
                    ) : (
                        <Typography sx={{ p: 2 }}>
                            No Notifications found
                        </Typography>
                    )}
                </Popover>
            </div>
        </>
    );
}
