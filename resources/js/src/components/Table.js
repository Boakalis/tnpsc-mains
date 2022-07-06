import React, { useState, useEffect } from "react";
import style from "./Breadcrumb.module.css";
import BreadCrumbs from "./BreadCrumbs";
import { Pagination } from "react-laravel-paginex";
import axios from "../helpers/axios";
import Table from "react-bootstrap/Table";
import TextLoader from "../UI/loader/TextLoader";
import { toastr } from "react-redux-toastr";
import CircularProgress from "@mui/material/CircularProgress";
import Nr from "../UI/loader/NoResult";
import moment from "moment";
import slugify from "react-slugify";
export default function DataTable() {
  const [data, setState] = useState();
  const [reports, setReport] = useState();
  const [loading, setLoading] = useState(true);
  const [page, setPage] = useState();
  const pageChange = (data) => {
    setLoading(true);

    axios
      .get(`/get-reports?page=${data.page}`)
      .then((resp) => {
        setState(resp.data);
        setReport(resp.data.data);
        setLoading(false);
      })
      .catch((error) => {
      });
  };
  useEffect(() => {
    axios
      .get(`/get-reports?page=1`)
      .then((resp) => {
        setState(resp.data);
        setReport(resp.data.data);
        setLoading(false);
      })
      .catch((error) => {
      });
  }, []);

  const getAnswer = (name, id) => {
    const targetElement = document.getElementById(`loaderA${id}`);
    targetElement.classList.remove("d-none");

    axios
      .get(`/get-answer/${id}`)
      .then((resp) => {
        const url = window.URL.createObjectURL(
            new Blob([resp.data], { type: "application/pdf" })
        );
        const link = document.createElement("a");
        link.href = url;
        link.download =
            slugify(name + "-evaluated") + ".pdf";
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
      <BreadCrumbs title={`My Reports`} />
      {loading == true ? (
        <TextLoader />
      ) : reports.length > 0 ? (
        <>
          <Table
            responsive
            striped
            bordered
            hover
            variant="dark"
            className="mt-5"
          >
            <thead>
              <tr>
                <th>#</th>
                <th>Test Name</th>
                <th>Course Name</th>
                <th>Attempted Date</th>
                <th>Evaluated Date</th>
                <th>Download Result</th>
              </tr>
            </thead>
            <tbody>
              {reports.map((x, index) => {
                return (
                  <>
                    <tr className="table-secondary">
                      <td className="text-center">{index + 1}</td>
                      <td className="text-center">{x.test.name}</td>
                      <td className="text-center">{x.test.course.exam.name}</td>
                      <td className="text-center">
                        {moment(x.created_at).format(
                          "dddd, MMMM Do YYYY, h:mm:ss a"
                        )}
                      </td>
                      <td className="text-center">
                        {x.evaluated_file != null
                          ? moment(x.updated_at).format(
                              "dddd, MMMM Do YYYY, h:mm:ss a"
                            )
                          : "NA"}
                      </td>
                      <td className="text-center">
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
                          "NA"
                        )}
                      </td>
                    </tr>
                  </>
                );
              })}
            </tbody>
          </Table>
          <Pagination
            style={{ justifyContent: "end" }}
            changePage={pageChange}
            data={data}
          />
        </>
      ) : (
        <Nr />
      )}
    </>
  );
}
