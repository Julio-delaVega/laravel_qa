/* IMPORTING FONT-AWESOME */

import { config, library, dom } from "@fortawesome/fontawesome-svg-core";
config.autoReplaceSvg = "nest";

import {
    faCaretUp,
    faCaretDown,
    faStar,
    faCheck
} from "@fortawesome/free-solid-svg-icons";

library.add(faCaretUp, faCaretDown, faStar, faCheck);

dom.watch();