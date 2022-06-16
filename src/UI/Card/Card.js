import React, { useState, useRef } from "react";
import "../../content/Content.css";
import Tooltip from "@mui/material/Tooltip";
import Button from "@mui/material/Button";
import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";
import Paper from "@mui/material/Paper";
import { styled } from "@mui/material/styles";
import axios from "./../../helpers/axios";
import download from "downloadjs";
import { toastr } from "react-redux-toastr";
import CircularProgress from "@mui/material/CircularProgress";
import AlertModal from "./../../components/Alert";
import { useSelector, useDispatch } from "react-redux";
import slugify from "react-slugify";
import Loader from "../loader/Loader";

const Card = (props) => {
  const [fileId, selectFileId] = useState();
  const [fileLoader, setfileLoader] = useState();
  const [heading, setHeading] = useState();
  const [subText, setSubText] = useState();
  const [modalState, setModalState] = useState(false);
  const user = useSelector((state) => state.authentication.user);
  const dispatch = useDispatch();

  let typeClass = "";
  if (props.data.type == 0) {
    typeClass = "bg-success text-uppercase";
  } else {
    typeClass = "bg-error text-uppercase";
  }

  const showNotification = () => {
    console.log(props.data);
    console.log("notification");
  };
  const fileRef = useRef();

  const loadScript = (src) => {
    return new Promise((resolve) => {
      const script = document.createElement("script");
      script.src = src;
      script.onload = () => {
        resolve(true);
      };
      script.onerror = () => {
        resolve(false);
      };
      document.body.appendChild(script);
    });
  };

  const startPayment = async (id) => {
    dispatch({ type: "OPEN_PAYMENT_LOADER" });
    const res = await loadScript(
      "https://checkout.razorpay.com/v1/checkout.js"
    );

    if (!res) {
      dispatch({ type: "CLOSE_PAYMENT_LOADER" });

      alert("Razorpay SDK failed to load. Are you online?");
      return;
    }
    var amount, order_id;
    await axios
      .post("/orders", {
        courseId: id,
        examId: 0,
      })
      .then((resp) => {
        amount = resp.data.amount;
        order_id = resp.data.order_id;
      })
      .catch((error) => {
        alert("Server error. Are you online?");
        dispatch({ type: "CLOSE_PAYMENT_LOADER" });
        return;
      });

    const options = {
      key: "rzp_test_UW6U9n7RwB0kfE", // Enter the Key ID generated from the Dashboard
      amount: amount,
      currency: "INR",
      name: "Soumya Corp.",
      description: "Test Transaction",
      image: null,
      order_id: order_id,
      modal: {
        ondismiss: function () {
          dispatch({ type: "CLOSE_PAYMENT_LOADER" });
        },
      },
      handler: async function (response) {
        console.log(response);
        const data = {
          orderCreationId: order_id,
          razorpayPaymentId: response.razorpay_payment_id,
          razorpayOrderId: response.razorpay_order_id,
          razorpaySignature: response.razorpay_signature,
        };
        dispatch({ type: "OPEN_PAYMENT_LOADER" });

        await axios
          .post("/payment-success", data)
          .then((resp) => {
            if ((resp.data.message = "SUCCESS")) {
              toastr.success(
                "Payment Successful",
                "Page will refresh automatically. Kindly wait"
              );
              dispatch({ type: "CLOSE_PAYMENT_LOADER" });
              window.location.reload();
            }
          })
          .catch((error) => {
            toastr.error("Payment Failed");
            dispatch({ type: "CLOSE_PAYMENT_LOADER" });
            setTimeout(() => {
              toastr.removeByType("error");
            }, 3000);
          });
        dispatch({ type: "CLOSE_PAYMENT_LOADER" });
      },
      prefill: {
        name: "Soumya Dey",
        email: "SoumyaDey@example.com",
        contact: "9999999999",
      },
      notes: {
        address: "Soumya Dey Corporate Office",
      },
      theme: {
        color: "#61dafb",
      },
    };

    const paymentObject = new window.Razorpay(options);
    dispatch({ type: "CLOSE_PAYMENT_LOADER" });
    paymentObject.open();
  };

  const getQuestion = (id) => {
    const targetElement = document.getElementById(`loaderG${id}`);
    targetElement.classList.remove("d-none");
    console.log(props.data);
    if (props.data.type == 0) {
      if (props.data.status == 2) {
        toastr.info(
          "Test Not yet unlocked",
          "Kindly check the schedule provided for more details"
        );
        setTimeout(() => {
          toastr.removeByType("info");
        }, 3000);
        targetElement.classList.add("d-none");
        return;
      }
      axios
        .get("/get-question/" + props.data.id, {
          responseType: "blob",
        })
        .then((resp) => {
          const url = window.URL.createObjectURL(
            new Blob([resp.data], { type: "application/octetstream" })
          );
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute(
            "download",
            slugify(props.data.name + "-question") + ".pdf"
          );
          // document.body.appendChild(link);
          link.click();
          link.remove();
          setTimeout(() => window.URL.revokeObjectURL(url), 100);
          targetElement.classList.add("d-none");
        })
        .catch((error) => {
          targetElement.classList.add("d-none");
          toastr.error(
            "Something went wrong.Try again Later or contact support"
          );
          setTimeout(() => {
            toastr.removeByType("error");
          }, 3000);
        });
      return;
    }
    axios
      .post("/payment-status", {
        courseId: id,
      })
      .then((resp) => {
        console.log(resp.data);
        if (resp.data.payment == 0) {
          targetElement.classList.add("d-none");
          startPayment(id);
        } else {
          if (props.data.status == 2) {
            toastr.info(
              "Test Not yet unlocked",
              "Kindly check the schedule provided for more details"
            );
            setTimeout(() => {
              toastr.removeByType("info");
            }, 3000);
            targetElement.classList.add("d-none");
            return;
          }
          axios
            .get("/get-question/" + props.data.id, {
              responseType: "blob",
            })
            .then((resp) => {
              const url = window.URL.createObjectURL(
                new Blob([resp.data], { type: "application/octetstream" })
              );
              const link = document.createElement("a");
              link.href = url;
              link.setAttribute(
                "download",
                slugify(props.data.name + "-question") + ".pdf"
              );
              // document.body.appendChild(link);
              link.click();
              link.remove();
              setTimeout(() => window.URL.revokeObjectURL(url), 100);
              targetElement.classList.add("d-none");
            })
            .catch((error) => {
              targetElement.classList.add("d-none");
              toastr.error(
                "Something went wrong.Try again Later or contact support"
              );
              setTimeout(() => {
                toastr.removeByType("error");
              }, 3000);
            });
        }
        targetElement.classList.add("d-none");
      })
      .catch((error) => {
        toastr.error("Something went wrong");
        setTimeout(() => {
          toastr.removeByType("error");
        }, 3000);
        targetElement.classList.add("d-none");
      });
  };

  const fileUpload = (id) => {
    const targetElement = document.getElementById(`loader${id}`);
    targetElement.classList.remove("d-none");

    selectFileId(id);

    if (props.data.type == 0) {
      if (props.data.status == 2) {
        toastr.info(
          "Test Not yet unlocked",
          "Kindly check the schedule provided for more details"
        );
        setTimeout(() => {
          toastr.removeByType("info");
        }, 3000);
        targetElement.classList.add("d-none");
        return;
      }
      fileRef.current.click();
      targetElement.classList.add("d-none");
      return;
    }

    axios
      .post("/payment-status", {
        courseId: id,
      })
      .then((resp) => {
        if (resp.data.payment == 0) {
          targetElement.classList.add("d-none");
          startPayment(id);
        } else {
          if (props.data.unlock_time != null) {
            toastr.info(
              "Test Not yet unlocked",
              "Kindly check the schedule provided for more details"
            );
            setTimeout(() => {
              toastr.removeByType("info");
            }, 3000);
            targetElement.classList.add("d-none");
            return;
          }
          fileRef.current.click();
          targetElement.classList.add("d-none");
        }
      });
  };

  const getAnswer = (id) => {
    const targetElement = document.getElementById(`loaderA${id}`);
    targetElement.classList.remove("d-none");
    if (props.data.type == 0) {
      if (props.data.status == 2) {
        toastr.info(
          "Test Not yet unlocked",
          "Kindly check the schedule provided for more details"
        );
        setTimeout(() => {
          toastr.removeByType("info");
        }, 3000);
        targetElement.classList.add("d-none");
        return;
      }
      axios
      .get(`/get-answer/${id}`)
      .then((resp) => {
        console.log(resp);
        const url = window.URL.createObjectURL(
          new Blob([resp.data], { type: "application/octetstream" })
        );
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute(
          "download",
          slugify(props.data.name + "-evaluated") + ".pdf"
        );
        // document.body.appendChild(link);
        link.click();
        link.remove();
        setTimeout(() => window.URL.revokeObjectURL(url), 100);
        targetElement.classList.add("d-none");
      })
      .catch((error) => {
        targetElement.classList.add("d-none");
        if (error.response.status == 401) {
          toastr.error("Please Submit test before asking evaluation");
          targetElement.classList.add("d-none");
        }
        if (error.response.status == 500) {
          toastr.error("Something went wrong!");
        }
        if (error.response.status == 403) {
          toastr.error(
            "Result Not Yet Avaliable",
            "We will notify as soon as result available"
          );
          setTimeout(() => {
            toastr.removeByType("error");
          }, 3000);
          targetElement.classList.add("d-none");
        }
      });
      return;
    }
    axios
      .post("/payment-status", {
        courseId: id,
      })
      .then((resp) => {
        if (resp.data.payment == 0) {
          targetElement.classList.add("d-none");
          startPayment(id);
        } else {
          axios
            .get(`/get-answer/${id}`)
            .then((resp) => {
              console.log(resp);
              const url = window.URL.createObjectURL(
                new Blob([resp.data], { type: "application/octetstream" })
              );
              const link = document.createElement("a");
              link.href = url;
              link.setAttribute(
                "download",
                slugify(props.data.name + "-evaluated") + ".pdf"
              );
              // document.body.appendChild(link);
              link.click();
              link.remove();
              setTimeout(() => window.URL.revokeObjectURL(url), 100);
              targetElement.classList.add("d-none");
            })
            .catch((error) => {
              targetElement.classList.add("d-none");
              if (error.response.status == 401) {
                toastr.error("Please Submit test before asking evaluation");
                targetElement.classList.add("d-none");
              }
              if (error.response.status == 500) {
                toastr.error("Something went wrong!");
              }
              if (error.response.status == 403) {
                toastr.error(
                  "Result Not Yet Avaliable",
                  "We will notify as soon as result available"
                );
                setTimeout(() => {
                  toastr.removeByType("error");
                }, 3000);
                targetElement.classList.add("d-none");
              }
            });
        }
      });
  };

  const handleFile = (event) => {
    const targetElement = document.getElementById(`loader${fileId}`);
    targetElement.classList.remove("d-none");
    const file = event.target.files[0];
    const size = Math.round(file.size / 1024 / 1024);
    if (size >= 10) {
      toastr.error("Please Upload File Less than 10MB ");
      setTimeout(() => {
        toastr.removeByType("error");
      }, 3000);
      targetElement.classList.add("d-none");
      return;
    }

    let formData = new FormData();
    formData.append("id", fileId);
    formData.append("file", file);

    axios
      .post("/submit-question", formData)
      .then((resp) => {
        console.log(resp);
        if (resp.data.status == "ok") {
          toastr.success("Test Submitted succesfully");
          setTimeout(() => {
            toastr.removeByType("success");
          }, 3000);
          targetElement.classList.add("d-none");
        }
      })
      .catch((error) => {
        targetElement.classList.add("d-none");
        toastr.error("Something went wrong.Try again Later or contact support");
        setTimeout(() => {
          toastr.removeByType("error");
        }, 3000);
      });
  };

  return (
    <>
      {/* <Loader></Loader> */}
      <div
        style={{
          backgroundColor: "#e7eee6",
        }}
        className="card-test col-4"
        data-tilt-glare=""
        data-tilt-max-glare="0.8"
      >
        <div className="ribbon ">
          <span className={typeClass}>
            {" "}
            {props.data.type == 1 ? "Premium" : "Free"}
          </span>
        </div>
        <div className="titleInfo">
          <div className="" style={{ width: "100%" }}>
            <div className="level">
              <h3 className="text-uppercase">{props.data.name}</h3>
              <p></p>
            </div>

            <div className="" style={{ marginTop: "2em" }}>
              <Stack
                direction="row"
                justifyContent="space-between"
                alignItems="center"
                spacing={2}
              >
                <Tooltip title="Get Question PDF for Evaluation">
                  <Button
                    style={{ fontSize: "12px" }}
                    variant="contained"
                    size="small"
                    color="success"
                    className="mx-1  text-center"
                    onClick={
                      user == null
                        ? () => {
                            dispatch({ type: "OPEN_LOGIN_MODAL" });
                          }
                        : () => getQuestion(props.data.id)
                    }
                  >
                    {/* <PictureAsPdfIcon /> */}
                    <CircularProgress
                      className="d-none"
                      id={`loaderG${props.data.id}`}
                      size="1rem"
                      style={{ color: "white" }}
                    />
                    Get Question
                  </Button>
                </Tooltip>

                <Tooltip title="Upload your Answered PDF for Evaluation ">
                  <Button
                    style={{ fontSize: "12px" }}
                    variant="contained"
                    color="warning"
                    size="small"
                    className="mx-1"
                    onClick={
                      user == null
                        ? () => {
                            dispatch({ type: "OPEN_LOGIN_MODAL" });
                          }
                        : () => fileUpload(props.data.id)
                    }
                  >
                    {/* <UploadFileIcon /> */}
                    <CircularProgress
                      className="d-none"
                      id={`loader${props.data.id}`}
                      size="1rem"
                      style={{ color: "white" }}
                    />
                    Upload Answer
                  </Button>
                </Tooltip>
              </Stack>
              <Stack
                direction="column"
                justifyContent="space-between"
                alignItems="center"
                spacing={2}
              >
                {props.data.videolink && (
                  <Tooltip title="Video Tutorial for the Test">
                    <Button
                      style={{ fontSize: "12px" }}
                      variant="contained"
                      color="secondary"
                      size="small"
                      className="mt-2 col-12"
                      onClick={
                        user == null
                          ? () => {
                              dispatch({ type: "OPEN_LOGIN_MODAL" });
                            }
                          : () => getAnswer(props.data.id)
                      }
                    >
                      &nbsp;&nbsp;Video Course
                    </Button>
                  </Tooltip>
                )}
                <Tooltip title="Available when uploaded question finished evaluation">
                  <Button
                    style={{ fontSize: "12px" }}
                    variant="contained"
                    color="primary"
                    size="small"
                    disabled={
                      user
                        ? props.data.test_attended &&
                          props.data.test_attended == true
                          ? false
                          : true
                        : false
                    }
                    className="mt-2 col-12"
                    onClick={
                      user == null
                        ? () => {
                            dispatch({ type: "OPEN_LOGIN_MODAL" });
                          }
                        : () => getAnswer(props.data.id)
                    }
                  >
                    <CircularProgress
                      className="d-none"
                      id={`loaderA${props.data.id}`}
                      size="1rem"
                      style={{ color: "white" }}
                    />
                    &nbsp;&nbsp;Evaluated Copy
                  </Button>
                </Tooltip>
              </Stack>

              {/* <button class="btn btn-primary btn-sm mx-1">Upload</button> */}
            </div>
          </div>
        </div>
      </div>
      <input
        type="file"
        style={{ display: "none" }}
        ref={fileRef}
        onChange={handleFile}
      />
    </>
  );
};

export default Card;
