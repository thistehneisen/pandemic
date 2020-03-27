#!/bin/bash

wget 'https://docs.google.com/spreadsheets/d/e/2PACX-1vS-g1rG7Jslb6g5FFZDs83MKl-7DYnEki-s70LbfCZvGSJNNRF6Ew3SdWFcX4hmm-41vqKvIpFpPdlN/pub?gid=0&single=true&output=csv' \
    -O data.csv

wget 'https://raw.githubusercontent.com/datasets/covid-19/master/time-series-19-covid-combined.csv' \
    -O combined.csv

wget 'https://open-covid-19.github.io/data/world_latest.json' \
    -O latest.json
