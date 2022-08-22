export const addPercentSign = (value) => value + '%'

export const formatDate = (timeStamp) => {
  const timeStampArray = timeStamp.split('/')
  return `${timeStampArray[2]}-${timeStampArray[0]}-${timeStampArray[1]}`
}

export const formatDateAndTime = (timeStamp) => {
  const timeStampArray = timeStamp.split(' ')
  const date = timeStampArray[0].split('/')
  const time = timeStampArray[1]

  return `${date[2]}-${date[0]}-${date[1]} ${time}:00`
}

export const formatDateFromAPI = (timestamp) => {
  const dateArr = timestamp.split('-')

  return `${dateArr[1]}/${dateArr[2]}/${dateArr[0]}`
}

export const formatDateAndTimeFromAPI = (timestamp) => {
  const dateAndTimeArr = timestamp.split(' ')

  const dateArr = dateAndTimeArr[0].split('-')
  const timeArr = dateAndTimeArr[1].split(':')

  return `${dateArr[1]}/${dateArr[2]}/${dateArr[0]} ${timeArr[0]}:${timeArr[1]}`
}

export const formatDateForCloseRegister = (timestamp) => {
  const day = timestamp.getDate()
  const month = timestamp.getMonth() + 1
  const year = timestamp.getFullYear()
  return `${month}/${day}/${year}`
}

export const formatDateForCloseRegisterAPI = (timestamp) => {
  const day = timestamp.getDate()
  const month = timestamp.getMonth() + 1
  const year = timestamp.getFullYear()
  return `${year}-${month}-${day}`
}
