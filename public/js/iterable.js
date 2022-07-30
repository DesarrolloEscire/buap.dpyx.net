class Iterable {

    constructor(items) {
        this.items = items
    }

    item(item) {
        return item
    }

    static iter(){
        return new this([])
    }

    [Symbol.iterator]() {
        var index = -1;
        var data = this.items;

        return {
            next: () => ({
                value: this.item(data[++index]),
                done: !(index in data)
            })
        };
    };
}