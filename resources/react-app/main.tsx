import React from "react";
import ReactDOM from "react-dom/client";
import {App} from "./page/App";

if (document.getElementById("app")) {

    const el = document.getElementById("app");
    const root = ReactDOM.createRoot(el!);

    root.render(
        <React.StrictMode>
            <App/>
        </React.StrictMode>
    );
}
