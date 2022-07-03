import React, { useState, useEffect } from "react";
import Breadcrumbs from "@mui/material/Breadcrumbs";
import Typography from "@mui/material/Typography";
import Link from "@mui/material/Link";
import Stack from "@mui/material/Stack";
import NavigateNextIcon from "@mui/icons-material/NavigateNext";
import { Col, Row } from "react-bootstrap";
import useBreadcrumbs from "use-react-router-breadcrumbs";
import { RepeatRounded } from "@mui/icons-material";
import { NavLink, useNavigate } from "react-router-dom";

export default function CustomSeparator(props) {
    const { title } = props;
    const breadcrumbsDatas = useBreadcrumbs();

    const navigate = useNavigate();
    // function handleClick(event) {
    //   console.info("You clicked a breadcrumb.");

    // }
    useEffect(() => {
        console.log(breadcrumbsDatas);
        breadcrumbsDatas.map((breadcrumb) => {
            console.log(
                decodeURIComponent(breadcrumb.breadcrumb.props.children)
            );
        });
    });

    return (
        <>
            <Row>
                <Col>
                    <h1
                        style={{ fontSize: "25px", fontWeight: 600 }}
                        className="text-uppercase"
                    >
                        {title}
                    </h1>
                </Col>
                <Col className="d-xl-block d-none">
                    <Stack
                        spacing={0}
                        direction="row"
                        justifyContent="flex-end"
                        alignItems="center"
                    >
                        <Breadcrumbs
                            separator={<NavigateNextIcon fontSize="small" />}
                            aria-label="breadcrumb"
                        >
                            {breadcrumbsDatas.map((breadcrumb, index) => {
                                {
                                    return (

                                        breadcrumb.match.pathname == "/" ? (
                                            <NavLink
                                                onClick={() => {
                                                    window.location.href = "/";
                                                }}
                                                key={index}
                                                className="text-uppercase "
                                                to={breadcrumb.match.pathname}
                                            >
                                                <span style={{ fontSize: "13px" }}>
                                                    {decodeURIComponent(
                                                        breadcrumb.breadcrumb.props
                                                            .children
                                                    )}
                                                </span>
                                            </NavLink>
                                        ) : (
                                            <NavLink
                                                exact
                                                key={index}
                                                className="text-uppercase "
                                                to={breadcrumb.match.pathname}
                                            >
                                                <span style={{ fontSize: "13px" }}>
                                                    {decodeURIComponent(
                                                        breadcrumb.breadcrumb.props
                                                            .children
                                                    )}
                                                </span>
                                            </NavLink>
                                        )
                                    )
                                }
                            })}
                        </Breadcrumbs>
                    </Stack>
                </Col>
            </Row>
        </>
    );
}
