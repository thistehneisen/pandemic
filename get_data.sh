#!/bin/bash

wget 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6e2eYL_dsCeuT6IFKcw07PD1ZY_kjhGtHDGlzPvKhID7_3nTgkQsbLux4J3jaLPomOUeWtW7kxe4c/pub?gid=0&single=true&output=csv' \
    -O data.csv

wget 'https://raw.githubusercontent.com/datasets/covid-19/master/time-series-19-covid-combined.csv' \
    -O combined.csv
