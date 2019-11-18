export default function setSlotData(cls, ...methods) {
    let data = {};

    for (const x in cls.$data) {
        data[x] = cls[x];
    }

    // set methods
    methods.forEach(x => {
        data[x] = cls[x]
    })

    return data
}
