package main

import (
	"testing"

	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/require"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

type testCase struct {
	str   string
	minor string
	want  string
}

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента
	testCases := []testCase{
		{str: "i am rich", minor: "", want: "I Am Rich"},
		{str: "go away", minor: "", want: "Go Away"},
		{str: "stuff", minor: "", want: "Stuff"},
	}

	for _, tc := range testCases {
		actual := titlecase.TitleCase(tc.str, tc.minor)
		require.Equal(t, tc.want, actual)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента
	testCases := []testCase{
		{str: "what is the matter with you", minor: "what", want: "What Is The Matter With You"},
		{str: "qqqq", minor: "qqqq", want: "Qqqq"},
		{str: "smells like teen spirit", minor: "smells", want: "Smells Like Teen Spirit"},
	}

	for _, tc := range testCases {
		actual := titlecase.TitleCase(tc.str, tc.minor)
		require.Equal(t, tc.want, actual)
	}
}

func TestWithMinorInSecond(t *testing.T) {

	testCases := []testCase{
		{str: "what is the matter with you", minor: "is the", want: "What is the Matter With You"},
		{str: "qqqq aaaa bbb", minor: "aaaa", want: "Qqqq aaaa Bbb"},
		{str: "smells like teen spirit", minor: "like teen", want: "Smells like teen Spirit"},
	}

	for _, tc := range testCases {
		actual := titlecase.TitleCase(tc.str, tc.minor)
		require.Equal(t, tc.want, actual)
	}

}

func TestWithWrongWordInMinorInSecond(t *testing.T) {

	testCases := []testCase{
		{str: "what is the matter with you", minor: "is thea", want: "What is The Matter With You"},
		{str: "qqqq aaaa bbb", minor: "aqaa bbb", want: "Qqqq Aaaa bbb"},
		{str: "smells like teen spirit", minor: "liqe teen", want: "Smells Like teen Spirit"},
	}

	for _, tc := range testCases {
		actual := titlecase.TitleCase(tc.str, tc.minor)
		require.Equal(t, tc.want, actual)
	}

}
