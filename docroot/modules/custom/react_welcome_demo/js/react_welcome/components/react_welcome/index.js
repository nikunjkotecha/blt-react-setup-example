import React from "react";
import Link from "../link";

export default class ReactWelcome extends React.Component {

  constructor(props) {
    super(props);

    const displayLinks = [];

    const {
      accountId,
      showLogin,
      showRegister,
      showMyAccount,
      showLogout,
    } = this.props;

    if (parseInt(accountId, 10) > 0) {
      if (showMyAccount) {
        displayLinks.push({
          label: Drupal.t("My Account"),
          path: Drupal.url("user"),
        });
      }

      if (showLogout) {
        displayLinks.push({
          label: Drupal.t("Logout"),
          path: Drupal.url("user/logout"),
        });
      }
    } else {
      if (showLogin) {
        displayLinks.push({
          label: Drupal.t("Login"),
          path: Drupal.url("user/login"),
        });
      }

      if (showRegister) {
        displayLinks.push({
          label: Drupal.t("Register"),
          path: Drupal.url("user/register"),
        });
      }
    }

    this.state = {
      displayLinks,
    };
  }

  render() {
    const { accountName } = this.props;
    const { displayLinks } = this.state;

    const displayLinksRender = displayLinks.map((link) => (
      <Link
        key={link.label}
        label={link.label}
        link={link.path}
      />
    ));

    return (
      <>
        <span className="welcome-user-name-wrapper">
          { Drupal.t("Welcome @name,", {"@name": accountName}) }
        </span>
        <ul className="welcome-links">
          { displayLinksRender }
        </ul>
      </>
    );
  }
}
