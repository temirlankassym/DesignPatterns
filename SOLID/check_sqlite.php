<?php

// Check if SQLite extension is loaded
if (extension_loaded('sqlite3')) {
    echo "SQLite is installed and enabled in PHP.";
} else {
    echo "SQLite is not installed or enabled in PHP.";
}
