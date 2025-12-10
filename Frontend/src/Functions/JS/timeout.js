function setTimeout(variable, value, milliseconds) {
  setTimeout(() => {
    variable = value;
  }, milliseconds);
  return variable;
}
export { setTimeout };
