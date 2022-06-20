import React, { useContext, useEffect, useState } from "react";
import "./Content.css";
import Tooltip from "@mui/material/Tooltip";
import { useParams } from "react-router-dom";
import Button from "@mui/material/Button";
import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";
import Chip from "@mui/material/Chip";
import Paper from "@mui/material/Paper";
import { styled } from "@mui/material/styles";
import "./VideoCard";
import Accordian from "../UI/Accordian/Accordian";
import axios from "../helpers/axios";
import style from "./../components/Breadcrumb.module.css";
import BreadCrumbs from "./../components/BreadCrumbs";
import { createPortal } from "react-dom";
import Loader from "./../UI/loader/Loader";
import { useDispatch } from "react-redux";
import { toastr } from "react-redux-toastr";
import TextLoader from "../UI/loader/TextLoader";
import Nr from "../UI/loader/NoResult";
import slugify from "react-slugify";

const Item = styled(Paper)(({ theme }) => ({
    backgroundColor: theme.palette.mode === "dark" ? "#1A2027" : "#fff",
    ...theme.typography.body2,
    padding: theme.spacing(1),
    textAlign: "center",
    color: theme.palette.text.secondary,
}));

function Content() {
    const dispatch = useDispatch();

    const slug = useParams();
    const [loading, setLoading] = useState(false);

    const [datas, setData] = useState(false);
    useEffect(() => {
        axios
            .get(`get-courses/${slug.plan}/${slug.slug}`)
            .then((resp) => {
                console.log(resp.data.data);
                setData(resp.data.data);
                setLoading(false);
            })
            .catch((error) => {
                console.log(error);
                setLoading(false);
            });
        return () => {};
    }, []);

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
                courseId: datas.id,
                examId: 1,
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

    const scheduleButton = () => {
        dispatch({ type: "OPEN_PAYMENT_LOADER" });
        axios
            .get(`/get-schedule/${datas.id}`)
            .then((resp) => {
                dispatch({ type: "CLOSE_PAYMENT_LOADER" });
                const url = window.URL.createObjectURL(
                    new Blob([resp.data], { type: "application/octetstream" })
                );
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute(
                    "download",
                    slugify(datas.exam.name + "-" + datas.name + "-schedule") +
                        ".pdf"
                );
                link.click();
                link.remove();
                setTimeout(() => window.URL.revokeObjectURL(url), 100);
                dispatch({ type: "CLOSE_PAYMENT_LOADER" });
            })
            .catch((error) => {
                dispatch({ type: "CLOSE_PAYMENT_LOADER" });
                // if (error.response.status == 401) {
                //   toastr.error("Please Submit test before asking evaluation");
                //   targetElement.classList.add("d-none");
                // }
                // if (error.response.status == 500) {
                toastr.error("Something went wrong!");
                // }
                // if (error.response.status == 403) {
                //   toastr.error(
                //     "Result Not Yet Avaliable",
                //     "We will notify as soon as result available"
                //   );
                //   setTimeout(() => {
                //     toastr.removeByType("error");
                //   }, 3000);
                //   targetElement.classList.add("d-none");
                // }
            });
    };

    return (
        <>
       
            {datas ? (
                datas.weeks == "undefined" ? (
                    <>
                        {datas.purchased == false &&
                            createPortal(
                                <div className="banner-outer pt-3">
                                    <div className="banner-inner responsive-wrapper">
                                        <h6 className="text-dark">
                                            {`Get Access to ${datas.exam.name}(${datas.name} Package) @₹${datas.price}/- Only`}
                                            <button
                                                onClick={startPayment}
                                                id="btn-sub"
                                                className=" mx-3 sub-btn btn btn-sm"
                                            >
                                                Buy Now
                                            </button>
                                        </h6>
                                    </div>
                                </div>,
                                document.getElementById("price-root")
                            )}
                        <BreadCrumbs
                            title={`${datas.exam.name} ${datas.name} course`}
                        />
                        <div className=" container row px-0 mt-4 mx-0">
                            {datas && (
                                <Typography
                                    variant="h5"
                                    className=" mt-3"
                                    gutterBottom
                                    component="div"
                                >
                                    EVALUATION SECTION{" "}
                                    <span style={{ float: "right" }}>
                                        <Chip
                                            label="Download Schedule"
                                            variant="outlined"
                                            color="success"
                                            onClick={scheduleButton}
                                        />
                                    </span>
                                </Typography>
                            )}
                            {datas &&
                                datas.weeks.map((data, index) => {
                                    return (
                                        <>
                                            <Accordian
                                                key={index}
                                                index={index}
                                                data={data}
                                            ></Accordian>
                                        </>
                                    );
                                })}
                        </div>
                    </>
                ) : (
                    <Nr></Nr>
                )
            ) : (
                <TextLoader></TextLoader>
            )}
        </>
    );
}

export default Content;
