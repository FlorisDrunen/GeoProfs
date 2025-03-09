const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    baseUrl: "http://localhost:8080", // Of een andere URL waar je Laravel-app draait
  },
});
