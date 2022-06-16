import React, { useRef, useState, useEffect, useImperativeHandle } from "react";

import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import Modal from "@mui/material/Modal";
import { createPortal } from "react-dom";
import { useSelector, useDispatch } from "react-redux";
import axios from "../helpers/axios";
import { Row, Container, Col } from "react-bootstrap";
// import "https://use.fontawesome.com/releases/v5.0.10/js/all.js";
import { toastr } from "react-redux-toastr";

const style = {
  position: "absolute",
  top: "50%",
  left: "50%",
  transform: "translate(-50%, -50%)",
  width: 400,
  bgcolor: "background.paper",
  border: "2px solid #000",
  boxShadow: 24,
  p: 4,
};

const AlertModal = (props) => {
  const [open, setOpen] = useState(true);
  const handleOpen = () => setOpen(false);
  const handleClose = () => setOpen(false);

  return (
    <>
      {createPortal(
        <>
          <div>
            <Modal
              open={props.state}
              onClose={handleClose}
              aria-labelledby="modal-modal-title"
              aria-describedby="modal-modal-description"
            >
              <Box sx={style}>
                <Typography className="text-center" id="modal-modal-title" variant="h6" component="h2">
                  {props.heading}
                </Typography>
                <Typography className="text-center"  id="modal-modal-description" sx={{ mt: 2 }}>
                    {props.subText}
                </Typography>
              </Box>
            </Modal>
          </div>
        </>,
        document.getElementById("modal-alert")
      )}
    </>
  );
};

export default AlertModal;
