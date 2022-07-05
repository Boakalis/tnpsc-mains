import { React, useState, useEffect } from "react";
import "./plans.css";
import Typography from "@mui/material/Typography";
import { Link, useParams } from "react-router-dom";
import axios from "../helpers/axios";
import { NavLink } from "react-router-dom";
import BreadCrumbs from "../components/BreadCrumbs";
import TextLoader from './../UI/loader/TextLoader'
function PackageComponent() {
  const [datas, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const { slug } = useParams();

  var planSlug = "";

  const returnSlug = (slug) => {
    planSlug = slug
      .toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");
  };

  useEffect(() => {
    axios
      .get(`get-plans/${slug}`)
      .then((resp) => {
        console.log(2);
        console.log(resp.data.data);
        console.log(2);
        setData(resp.data.data);
        setLoading(false);
      })
      .catch((error) => {
        console.log(error);
      });
    return () => {};
  }, []);

  return (
    <>
      {!loading && <BreadCrumbs title={`${datas[0].exam.name} COURSE PLANS`} />}
      <div className="mt-4">
        <div className="inner-header flex">
          <section style={{ padding: 0 }}>
            <div className="pricing pricing-palden">
              {loading ? (
               <TextLoader></TextLoader>
              ) : (
                datas.map((data, index) => (
                  <div
                    className="pricing-item features-item mx-1 my-2 pricing__item--featured ja-animate"
                    data-animation="move-from-bottom"
                    data-delay="item-0"
                    style={{ minHeight: 497 }}
                  >
                    <div
                      className="pricing-deco"
                      style={
                        index == 0
                          ? {
                              background:
                                " linear-gradient(to right, #4ca1af, #c4e0e5)",
                              height: "10px",
                            }
                          : index == 1
                          ? {
                              background:
                                "linear-gradient(to right, #eacda3, #d6ae7b)",
                              height: "10px",
                            }
                          : index == 2
                          ? {
                              background:
                                "linear-gradient(to right, #43c6ac, #f8ffae)",
                              height: "10px",
                            }
                          : { background: "lightblue", height: "10px" }
                      }
                    >
                      <h3 className="pricing-title text-dark">
                        {data.name} Plan
                      </h3>
                      <div className="pricing-price mt-4">
                        <span className="pricing-currency">&#8377;</span>
                        {data.price}{" "}

                        {/* <span className="pricing-period">/ day</span> */}
                      </div>
                    </div>
                    <ul className="pricing-feature-list mx-2">
                      {data.description
                        ? data.description.map((benefit, index) => (
                            <li className="pricing-feature" key={index}>
                              <i class="fa-solid text-success fa-check"></i>&nbsp;{benefit}
                            </li>
                          ))
                        : ""}
                    </ul>
                    {returnSlug(data.name)}
                    <NavLink
                      className="pricing-action"
                      exact
                      to={`/exams/${data.exam.slug}/${planSlug}`}
                    >
                      Browse Content
                    </NavLink>
                  </div>
                ))
              )}
            </div>
          </section>
        </div>
        <div>
          <svg
            className="waves"
            xmlns="http://www.w3.org/2000/svg"
            xmlnsXlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28"
            preserveAspectRatio="none"
            shapeRendering="auto"
          >
            <defs>
              <path
                id="gentle-wave"
                d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"
              />
            </defs>
            <g className="parallax">
              <use
                xlinkHref="#gentle-wave"
                x={48}
                y={0}
                fill="rgba(255,255,255,0.7"
              />
              <use
                xlinkHref="#gentle-wave"
                x={48}
                y={3}
                fill="rgba(255,255,255,0.5)"
              />
              <use
                xlinkHref="#gentle-wave"
                x={48}
                y={5}
                fill="rgba(255,255,255,0.3)"
              />
              <use xlinkHref="#gentle-wave" x={48} y={7} fill="#fff" />
            </g>
          </svg>
        </div>
      </div>
    </>
  );
}

export default PackageComponent;
