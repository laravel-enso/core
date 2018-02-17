import Vue from 'vue';
import { distanceInWordsToNow } from 'date-fns/esm';

Vue.filter('timeFromNow', value => distanceInWordsToNow(value));
