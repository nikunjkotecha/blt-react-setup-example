import React from "react";
import { createRoot } from "react-dom/client";
import ReactWelcome from "./react_welcome/components/react_welcome";

(function renderWelcomeBlockWrapper ($, settings) {
  $(".react-welcome-wrapper").each(function renderWelcomeBlock() {
    const { user: { uid } } = settings;
    const {
      username,
      showlogin,
      showregister,
      showmyaccount,
      showlogout,
    } = $(this).data();

    const root = createRoot(this);

    root.render(
      <ReactWelcome
        accountId={uid}
        accountName={username}
        showLogin={showlogin}
        showRegister={showregister}
        showMyAccount={showmyaccount}
        showLogout={showlogout}
      />
    );
  });
})(jQuery, drupalSettings);

