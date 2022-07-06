import { React, useState, useEffect } from "react";
import Box from "@mui/material/Box";
import Container from "@mui/material/Container";
import CssBaseline from "@mui/material/CssBaseline";
import Card from "./../components/Card";
import Grid from "@mui/material/Grid";
import Typography from "@mui/material/Typography";
import BreadCrumbs from "./../components/BreadCrumbs";
import axios from "./../helpers/axios";
import Skeleton from "@mui/material/Skeleton";
import "./../Exams/Exam.css";
import { useSelector } from "react-redux";
import TextLoader from "../UI/loader/TextLoader";
import { useNavigate } from "react-router-dom";

import { toastr } from "react-redux-toastr";
import CircularProgress from "@mui/material/CircularProgress";
import Nr from "../UI/loader/NoResult";
import moment from "moment";
import slugify from "react-slugify";

function Dashboard() {
  const [time, setTime] = useState([]);
  const [data, setData] = useState();
  const [loading, setLoading] = useState(true);
  const [pageLoading, setPageLoading] = useState(true);
  const user = useSelector((state) => state.authentication.user);
  const navigate = useNavigate();
  const getGreetings = () => {
    const date = new Date();
    const hour = date.getHours();
    setTime(hour);
    axios
      .get("/analytics-data")
      .then((resp) => {
        setData(resp.data);
        setPageLoading(false);
      })
      .catch((error) => {

      });
  };

  useEffect(() => {
    getGreetings();
  }, []);

  const navigateFunction = (examSlug, courseSlug) => {
    navigate(`/exams/${examSlug}/${courseSlug}`);
  };

  const getAnswer = (name, id) => {
    const targetElement = document.getElementById(`loaderA${id}`);
    targetElement.classList.remove("d-none");

    axios
      .get(`/get-answer/${id}`,{responseType:'blob'})
      .then((resp) => {
        const url = window.URL.createObjectURL(
          new Blob([resp.data], { type: "application/pdf" })
        );
        const link = document.createElement("a");
        link.href = url;
        link.download = slugify(name+"-evaluated")+".pdf";
        link.click();
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
  };

  return (
    <>
      {pageLoading ? (
        <TextLoader></TextLoader>
      ) : (
        <>
          <CssBaseline />
          {!loading && <BreadCrumbs title={`MY DASHBOARD`} />}

          <div className="container-xxl flex-grow-1 container-p-y">
            <div className="row">
              <div className="col-lg-12 mb-4 order-0">
                <div className="card">
                  <div className="d-flex align-items-end row">
                    <div className="col-sm-7">
                      <div className="card-body">
                        <h5
                          style={{ textAlign: "start", fontWeight: "700" }}
                          className="card-title text-uppercase text-primary"
                        >
                          {time < 12
                            ? "Good Morning"
                            : time < 15
                            ? "Good Afternoon"
                            : "Good Evening"}{" "}
                          {user.name}!
                        </h5>
                        <h6
                          className="mb-2 text-uppercase "
                          style={{ textAlign: "start", fontWeight: "700" }}
                        >
                          Today's words
                        </h6>
                        <p className="mb-4">{data?.quote?.quote}</p>
                      </div>
                    </div>
                    <div className="col-sm-5 text-center text-sm-left">
                      <div className="card-body pb-0 px-0 px-md-4">
                        <img
                          src="../assets/img/illustrations/man-with-laptop-light.png"
                          height={140}
                          alt="View Badge User"
                          data-app-dark-img="illustrations/man-with-laptop-dark.png"
                          data-app-light-img="illustrations/man-with-laptop-light.png"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {/* <div className="col-lg-4 col-md-4 order-1">
      <div className="row">
        <div className="col-lg-6 col-md-12 col-6 mb-4">
          <div className="card">
            <div className="card-body">
              <div className="card-title d-flex align-items-start justify-content-between">
                <div className="avatar flex-shrink-0">
                  <img
                    src="../assets/img/icons/unicons/chart-success.png"
                    alt="chart success"
                    className="rounded"
                  />
                </div>
                <div className="dropdown">
                  <button
                    className="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i className="bx bx-dots-vertical-rounded" />
                  </button>
                  <div
                    className="dropdown-menu dropdown-menu-end"
                    aria-labelledby="cardOpt3"
                  >
                    <a className="dropdown-item" href="javascript:void(0);">
                      View More
                    </a>
                    <a className="dropdown-item" href="javascript:void(0);">
                      Delete
                    </a>
                  </div>
                </div>
              </div>
              <span className="fw-semibold d-block mb-1">Profit</span>
              <h3 className="card-title mb-2">$12,628</h3>
              <small className="text-success fw-semibold">
                <i className="bx bx-up-arrow-alt" /> +72.80%
              </small>
            </div>
          </div>
        </div>
        <div className="col-lg-6 col-md-12 col-6 mb-4">
          <div className="card">
            <div className="card-body">
              <div className="card-title d-flex align-items-start justify-content-between">
                <div className="avatar flex-shrink-0">
                  <img
                    src="../assets/img/icons/unicons/wallet-info.png"
                    alt="Credit Card"
                    className="rounded"
                  />
                </div>
                <div className="dropdown">
                  <button
                    className="btn p-0"
                    type="button"
                    id="cardOpt6"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i className="bx bx-dots-vertical-rounded" />
                  </button>
                  <div
                    className="dropdown-menu dropdown-menu-end"
                    aria-labelledby="cardOpt6"
                  >
                    <a className="dropdown-item" href="javascript:void(0);">
                      View More
                    </a>
                    <a className="dropdown-item" href="javascript:void(0);">
                      Delete
                    </a>
                  </div>
                </div>
              </div>
              <span>Sales</span>
              <h3 className="card-title text-nowrap mb-1">$4,679</h3>
              <small className="text-success fw-semibold">
                <i className="bx bx-up-arrow-alt" /> +28.42%
              </small>
            </div>
          </div>
        </div>
      </div>
    </div> */}
              {/* Total Revenue */}
              <div className="col-12 col-lg-6  mb-4">
                <div className="card">
                  <div className="row row-bordered g-0">
                    <div className="col-12">
                      <h5 className="card-header m-0 me-2 pb-3">
                        Purchased Course
                      </h5>
                      <div id="totalRevenueChart" className="px-2" />
                      <div className="card-body pt-3">
                        <ul className="p-0 m-0">
                          {data?.purchase_data.length > 0 ?  (data?.purchase_data?.map((x) => {
                            return (
                              <li className="d-flex mb-4 pb-1">
                                <div className="avatar flex-shrink-0 me-3">
                                  <i
                                    class="fa-solid  fa-book text-primary"
                                    style={{ fontSize: "2.6em" }}
                                  ></i>
                                </div>
                                <div className="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                  <div className="me-2">
                                    <small className="text-muted d-block mb-1">
                                      {x.courses.name}
                                    </small>
                                    <h6
                                      style={{ textAlign: "start" }}
                                      className="mb-0"
                                    >
                                      {x.exams.name}
                                    </h6>
                                  </div>
                                  <div className="user-progress d-flex align-items-center gap-1">
                                    <button
                                      onClick={() => {
                                        navigateFunction(
                                          x.exams.slug,
                                          x.courses.slug
                                        );
                                      }}
                                      class="btn btn-light btn-sm"
                                    >
                                      <i
                                        class="fa-solid  text-dark fa-arrow-right-to-bracket"
                                        style={{ fontSize: "2.5em" }}
                                      ></i>
                                    </button>
                                  </div>
                                </div>
                              </li>
                            );
                          })) : (
                              <div className="text-center">
                                  <span className="">No Purchases Found</span>
                              </div>
                          )}
                        </ul>
                        {/* <div className="text-center">
                          <button class="btn btn-primary btn-sm">
                            View More
                          </button>
                        </div> */}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-12 col-lg-6  mb-4">
                <div className="card">
                  <div className="row row-bordered g-0">
                    <div className="col-12">
                      <h5 className="card-header m-0 me-2 pb-3">
                        Latest Tests Updates
                      </h5>
                      <div id="totalRevenueChart" className="px-2" />
                      <div className="card-body">
                        <ul className="p-0 m-0">
                        {data?.evaluated_reports.length > 0 ?  (data?.evaluated_reports?.map((x) => {
                            return (
                              <li className="d-flex mb-4 pb-1">
                                <div className="avatar flex-shrink-0 me-3">
                                  <i
                                    class="fa-solid  fa-file-pen text-primary"
                                    style={{ fontSize: "2.5em" }}
                                  ></i>
                                </div>
                                <div className="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                  <div className="me-2">
                                    <small className="text-muted d-block mb-1">
                                      {x.test.course.exam.name}
                                    </small>
                                    <h6 className="mb-0">{x.test.name}</h6>
                                  </div>

                                  <div className="me-2">
                                    {/* <small className="text-muted d-block mb-1">
                                      {x.test.course.exam.name}
                                    </small> */}
                                    <span
                                      className={`badge p-3 bg-label-${
                                        x.status == 1
                                          ? "primary"
                                          : x.status == 0
                                          ? "info"
                                          : "secondary"
                                      }  me-1`}
                                    >
                                      {x.status == 1
                                        ? "Evaluated"
                                        : x.status == 0
                                        ? "Submitted"
                                        : "Under Evaluation"}
                                    </span>
                                  </div>
                                  <div className="me-2">
                                    {/* <small className="text-muted d-block mb-1">
                                      {x.test.course.exam.name}
                                    </small> */}
                                    {x.evaluated_file != null ? (
                                      <button
                                        onClick={() => {
                                          getAnswer(x.test.name, x.test.id);
                                        }}
                                        className="btn btn-success btn-sm"
                                      >
                                        <CircularProgress
                                          className="d-none"
                                          id={`loaderA${x.test.id}`}
                                          size="1rem"
                                          style={{ color: "white" }}
                                        />
                                        <i className="fa fa-download"></i>
                                      </button>
                                    ) : (
                                      <button
                                        onClick={() => {
                                          getAnswer(x.test.name, x.test.id);
                                        }}
                                        className="btn btn-success btn-sm"
                                      >
                                        <CircularProgress
                                          className="d-none"
                                          id={`loaderA${x.test.id}`}
                                          size="1rem"
                                          style={{ color: "white" }}
                                        />
                                        <i className="fa fa-download"></i>
                                      </button>
                                    )}
                                  </div>
                                </div>
                              </li>
                            );
                          })):(

                                <div className="text-center">
                                    <span className="">No Tests Found</span>
                                </div>
                            )}

                        </ul>
                        {/* <div className="text-center">
                          <button class="btn btn-primary btn-sm">
                            View More
                          </button>
                        </div> */}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {/*/ Total Revenue */}
            </div>
          </div>
        </>
      )}
    </>
  );
}

export default Dashboard;
