export class MaterialAlgecoSignHelper {
  constructor(formName) {
    this.formName = formName;
    this.maxAisleNumber = 999;
    this.aisleNumberInput = document.getElementById(`${formName}_aisleNumber`);
    this.dirSelect = document.getElementById(`${formName}_dir`);
    this.aisleNumber = document.getElementsByClassName(
      "aisle-number-container"
    )[0];
    this.template = document.getElementById("material-algeco");

    this.refreshVueState();
    this.addAisleNumberInputEventListener();
    this.addDirSelectEventListener();
  }

  refreshVueState() {
    this._checkAisleMaxNumber();
    this._refreshSignPreview();
  }

  _checkAisleMaxNumber() {
    if (this.aisleNumberInput.value > this.maxAisleNumber) {
      this.aisleNumberInput.value = this.maxAisleNumber;
    }
  }

  _refreshSignPreview() {
    this.aisleNumber.innerText = this.aisleNumberInput.value;
    this.template.classList.remove("dir-r");
    this.template.classList.remove("dir-l");
    this.template.classList.add(`dir-${this.dirSelect.value}`);
  }

  addAisleNumberInputEventListener() {
    this.aisleNumberInput.addEventListener("keyup", () => {
      this.refreshVueState();
    });
  }

  addDirSelectEventListener() {
    this.dirSelect.addEventListener("change", () => {
      this.refreshVueState();
    });
  }
}
