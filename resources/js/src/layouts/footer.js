import { React } from "react";

const Footer = () => {
    return (
        <>
            <footer className="content-footer footer bg-footer-theme">
                <div className="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div className="mb-2 mb-md-0">
                        © Tnpsc Mains @2022
                        <a
                            href="https://tnpscmains.com"
                            target="_blank"
                            className="footer-link fw-bolder"
                        >

                        </a>
                    </div>
                    <div>
                        <a
                            href="https://tnpscmains.com/terms-and-condition"
                            className="footer-link me-4"
                            target="_blank"
                        >
                            Terms And Conditions
                        </a>
                        <a
                            href="https://tnpscmains.com/privacy-policy"
                            target="_blank"
                            className="footer-link me-4"
                        >
                            Privacy Policy
                        </a>
                    </div>
                </div>
            </footer>
        </>
    );
};

export default Footer;
