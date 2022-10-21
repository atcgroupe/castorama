export class MaterialAlgecoSignHelper {
    constructor(formName) {
        this.formName = formName;
        this.maxAisleNumber = 999;
        this.aisleNumberInput = document.getElementById(`${formName}_aisleNumber`);
        this.dirSelect = document.getElementById(`${formName}_dir`);
        this.itemsSelects = document.getElementsByClassName('sign-item-select');
        this.item2Select = document.getElementById(`${formName}_item2`);
        this.item3Select = document.getElementById(`${formName}_item3`);
        this.item4Select = document.getElementById(`${formName}_item4`);
        this.aisleNumber = document.getElementsByClassName('aisle-number-container')[0];
        this.text = document.getElementsByClassName('items_text')[0];
        this.template = document.getElementById('material-algeco');

        this.refreshVueState();
        this.addAisleNumberInputEventListener();
        this.addItemsSelectEventListeners();
        this.addDirSelectEventListener();
    }

    refreshVueState() {
        this._checkAisleMaxNumber();
        this._refreshSelectsStatus();
        this._refreshSignPreview();
    }

    _checkAisleMaxNumber() {
        if (this.aisleNumberInput.value > this.maxAisleNumber) {
            this.aisleNumberInput.value = this.maxAisleNumber;
        }
    }

    _refreshSignPreview() {
        this.aisleNumber.innerText = this.aisleNumberInput.value;

        let text = '';

        Array.from(this.itemsSelects).forEach((select, index) => {
            const itemLabel = select.options[select.selectedIndex].text;
            if (index === 0) text = `• ${itemLabel}`;

            if (index > 0 && itemLabel !== '') {
                text += `<br>• ${itemLabel}`;
            }
        })

        this.text.innerHTML = text;

        this.template.classList.remove('dir-r');
        this.template.classList.remove('dir-l');
        this.template.classList.add(`dir-${this.dirSelect.value}`)
    }

    _refreshSelectsStatus() {
        if (this.item2Select.value !== '') {
            this._enableSelect(this.item3Select);
        }

        if (this.item3Select.value !== '') {
            this._enableSelect(this.item4Select);
        }

        if (this.item2Select.value === '') {
            this._disableSelect(this.item3Select);
            this._disableSelect(this.item4Select);
            return;
        }

        if (this.item3Select.value === '') {
            this._disableSelect(this.item4Select);
        }
    }

    _disableSelect(select) {
        select.value = '';
        select.setAttribute('disabled', 'disabled');
    }

    _enableSelect(select) {
        select.removeAttribute('disabled');
    }

    addAisleNumberInputEventListener() {
        this.aisleNumberInput.addEventListener('keyup', () => {
            this.refreshVueState();
        })
    }

    addItemsSelectEventListeners() {
        Array.from(this.itemsSelects).forEach(select => {
            select.addEventListener('change', () => {
                this.refreshVueState();
            });
        })
    }

    addDirSelectEventListener() {
        this.dirSelect.addEventListener('change', () => {
            this.refreshVueState();
        });
    }
}
