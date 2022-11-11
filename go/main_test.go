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
	name string
	str string
	minor string
	want string
}



func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	const str, minor, want = "wow that's test string!", "", "Wow That'S Test String!"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	const str, minor, want = "wow that's test string!", "wow", "Wow That'S Test String!" //First word always capitilized
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithMinorShortForm(t *testing.T) {
	const str, minor, want = "wow that's test string!", "s", "Wow That'S Test String!"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}


func TestWithTable(t *testing.T) {
	testCases := []testCase{
		testCase{
			name: "empty",
			str: "",
			minor: "",
			want: "",
		},
		testCase{
			name: "no minor",
			str: "wow that's test string!",
			minor: "",
			want: "Wow That'S Test String!",
		},
		testCase{
			name: "first minor",
			str: "wow that's test string!",
			minor: "wow",
			want: "Wow That'S Test String!",
		},
		testCase{
			name: "minor short form",
			str: "wow that's test string!",
			minor: "s",
			want: "Wow That'S Test String!",
		},
	}
	for _, tc := range testCases {
		t.Run(tc.name, func(t *testing.T){
			require.Equal(t, tc.want, titlecase.TitleCase(tc.str, tc.minor))

		})
	}
}