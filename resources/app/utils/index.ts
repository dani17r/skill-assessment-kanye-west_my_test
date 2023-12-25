import { words, map, join, upperCase, head } from "lodash";

export const getFirstTwoInitialLetter = (val: string) => {
  const words_ = words(val);
  const initials = map(words_.slice(0, 2), (word) => upperCase(head(word)));
  return join(initials, "");
}