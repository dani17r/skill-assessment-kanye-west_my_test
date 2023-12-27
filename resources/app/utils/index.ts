import { words, map, join, upperCase, head } from "lodash";

export const getFirstTwoInitialLetter = (val: string) => {
  const words_ = words(val);
  const initials = map(words_.slice(0, 2), (word) => upperCase(head(word)));
  return join(initials, "");
}

export const formatDate = (value: string | Date) => {
  const date = new Date(value);
  return `${date.getFullYear()}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getDate().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')} ${date.getHours() >= 12 ? 'PM' : 'AM'}`;
}

export const debounceIndex = (func, delay = 300) => {
  let timeout = {};

  return function (index = 0, ...args) {
    const context = this;
    const later = function () {
      clearTimeout(timeout[index]);
      timeout[index] = setTimeout(() => func.apply(context, args), delay);
    };

    if (timeout[index]) {
      clearTimeout(timeout[index]);
    }

    timeout[index] = setTimeout(later, delay);
  };
}