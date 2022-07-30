class OrcidValidator {

    validate(string) {
        if (!string.length) {
            throw "el orcid no puede ser un campo vacío"
        }

        const pattern = /(\d{4}-){3}\d{3}(\d|X)/

        if (!pattern.test(string)) {
            throw "no es un orcid válido"
        }
    }
}

class EmptyValidator {
    validate(string) {
        return
    }
}

class Validator {

    constructor() {
        this.validators = {
            "dc.identifier.orcid": new OrcidValidator()
        }
    }

    for (validatorName) {
        return this.validators[validatorName] ?? new EmptyValidator()
    }

}

export default Validator